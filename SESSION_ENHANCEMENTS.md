# Session Tracking Enhancements

## Overview
The application now includes comprehensive session tracking, analytics, abandoned cart recovery, user preferences, and security features.

## Features Implemented

### 1. Session Analytics & Page View Tracking
- **Model**: `SessionAnalytic`
- **Table**: `session_analytics`
- **Features**:
  - Tracks every page visit with timestamp
  - Records device type (mobile, tablet, desktop)
  - Captures browser and platform information
  - Calculates session duration
  - Stores referrer information
  - Detects suspicious activity

**Usage**:
```php
// Get current session analytics
$analytics = session_analytics();

// Get page views
$pageViews = $analytics->page_views;

// Get session duration
$duration = $analytics->session_duration; // in seconds
```

### 2. Abandoned Cart Recovery
- **Model**: `AbandonedCart`
- **Table**: `abandoned_carts`
- **Features**:
  - Automatically tracks carts abandoned for 30+ minutes
  - Stores complete cart data for recovery
  - Tracks recovery email status
  - Associates with authenticated users
  - Supports cart recovery workflow

**Usage**:
```php
// Get recent abandoned carts
$carts = AbandonedCart::abandoned()->recent(24)->get();

// Mark cart as recovered
$cart->markAsRecovered();

// Send recovery email
$cart->markRecoveryEmailSent();
```

**Artisan Command**:
```bash
# Process abandoned carts and send recovery emails
php artisan carts:process-abandoned
```

**Schedule** (add to `app/Console/Kernel.php`):
```php
$schedule->command('carts:process-abandoned')->hourly();
```

### 3. User Preferences
- **Model**: `UserPreference`
- **Table**: `user_preferences`
- **Features**:
  - Stores language and currency preferences
  - Tracks recently viewed products (last 20)
  - Records search history (last 50)
  - Manages notification preferences
  - Supports theme selection
  - Custom settings storage

**Usage**:
```php
// Get user preferences
$prefs = user_preferences();

// Track product view
track_product_view($productId);

// Track search
track_search('sneakers');

// Add to recently viewed
$prefs->addRecentlyViewed($productId);

// Add search term
$prefs->addSearchTerm('running shoes');
```

### 4. Session Security
- **Service**: `SessionSecurityService`
- **Features**:
  - Detects IP address changes
  - Detects user agent changes
  - Identifies unusual activity patterns
  - Rate limiting (100 requests/minute)
  - Session validation
  - Suspicious activity logging

**Security Checks**:
- IP address consistency
- User agent consistency
- Activity pattern analysis
- Bot detection (high page views in short time)
- Session expiration (24 hours)

### 5. Guest-to-User Association
- **Feature**: Automatic cart and data migration
- **Triggers**: When user logs in
- **Migrates**:
  - Session analytics
  - Abandoned carts
  - User preferences
  - Cart contents (optional)

## Database Schema

### session_analytics
```sql
- id
- session_id (unique)
- user_id (indexed)
- auth_user_id (nullable, foreign key)
- ip_address
- user_agent
- current_page
- referrer
- page_views (JSON)
- total_page_views
- first_visit_at
- last_activity_at
- session_duration
- is_suspicious
- device_type
- browser
- platform
- timestamps
```

### abandoned_carts
```sql
- id
- session_id (indexed)
- user_id (indexed)
- auth_user_id (nullable, foreign key)
- email (indexed)
- cart_data (JSON)
- cart_total
- items_count
- delivery_option
- abandoned_at
- recovered_at
- recovery_email_sent
- recovery_email_sent_at
- status (abandoned/recovered/expired)
- timestamps
```

### user_preferences
```sql
- id
- user_id (unique)
- auth_user_id (nullable, foreign key)
- preferred_language
- preferred_currency
- favorite_categories (JSON)
- recently_viewed (JSON)
- search_history (JSON)
- email_notifications
- sms_notifications
- theme
- custom_settings (JSON)
- timestamps
```

## Middleware Flow

```
Request
  ↓
TrackSessionDetails Middleware
  ↓
1. Generate/retrieve user_id
2. Security checks (hijacking detection, rate limiting)
3. Track session analytics & page views
4. Track abandoned carts (if inactive 30+ min)
5. Initialize user preferences
6. Associate guest data with authenticated user
7. Update session details
  ↓
Application
  ↓
Response
```

## Helper Functions

```php
// Get user preferences
$prefs = user_preferences();

// Track product view
track_product_view($productId);

// Track search
track_search('search term');

// Get session analytics
$analytics = session_analytics();
```

## Configuration

### Enable/Disable Features

Edit `app/Http/Middleware/TrackSessionDetails.php`:

```php
// Disable suspicious activity detection
// Comment out the security check section

// Adjust abandoned cart timeout
// Change 30 minutes to desired value

// Disable rate limiting
// Comment out rate limit check
```

### Customize Thresholds

In `SessionSecurityService`:
```php
// Rate limit: 100 requests/minute
// Change in checkRateLimit() method

// Session expiration: 24 hours
// Change in validateSession() method

// Bot detection: 100 views in 5 minutes
// Change in hasUnusualActivityPattern() method
```

## Analytics & Reporting

### Get Session Statistics
```php
// Total sessions today
$todaySessions = SessionAnalytic::whereDate('created_at', today())->count();

// Average session duration
$avgDuration = SessionAnalytic::avg('session_duration');

// Most viewed pages
$analytics = SessionAnalytic::all();
$pageViews = $analytics->flatMap(fn($a) => $a->page_views)->groupBy('url');

// Device breakdown
$devices = SessionAnalytic::selectRaw('device_type, count(*) as count')
    ->groupBy('device_type')
    ->get();
```

### Abandoned Cart Reports
```php
// Abandoned carts value
$totalValue = AbandonedCart::abandoned()->sum('cart_total');

// Recovery rate
$total = AbandonedCart::count();
$recovered = AbandonedCart::where('status', 'recovered')->count();
$rate = ($recovered / $total) * 100;

// Top abandoned products
$carts = AbandonedCart::abandoned()->get();
$products = $carts->flatMap(fn($c) => $c->cart_data)->groupBy('product_id');
```

## Performance Considerations

1. **Indexing**: All frequently queried columns are indexed
2. **JSON Storage**: Cart data and preferences use JSON for flexibility
3. **Cleanup**: Run scheduled task to archive/delete old data
4. **Caching**: Consider caching user preferences for frequent access

## Future Enhancements

- Email templates for abandoned cart recovery
- A/B testing for recovery email timing
- Geolocation tracking for IP addresses
- Advanced bot detection with machine learning
- Real-time analytics dashboard
- Customer segmentation based on behavior
- Personalized product recommendations

## Security Notes

- All session data is encrypted by Laravel
- Suspicious activity is logged for review
- Rate limiting prevents abuse
- Session validation prevents hijacking
- CSRF protection is maintained

## Maintenance

### Clean Up Old Data
```php
// Delete old session analytics (90+ days)
SessionAnalytic::where('created_at', '<', now()->subDays(90))->delete();

// Delete expired abandoned carts
AbandonedCart::where('status', 'expired')->delete();
```

### Monitor Suspicious Activity
```php
// Get suspicious sessions
$suspicious = SessionAnalytic::where('is_suspicious', true)->get();

// Review and take action
foreach ($suspicious as $session) {
    Log::warning('Suspicious session', [
        'session_id' => $session->session_id,
        'user_id' => $session->user_id,
        'ip' => $session->ip_address,
    ]);
}
```

## Dependencies

- `jenssegers/agent` - User agent parsing
- Laravel Cache - Rate limiting
- Laravel Queue - Background processing (recommended for emails)

## Testing

```bash
# Test abandoned cart processing
php artisan carts:process-abandoned

# Check session analytics
php artisan tinker
>>> SessionAnalytic::count()
>>> AbandonedCart::abandoned()->count()
>>> UserPreference::count()
```
