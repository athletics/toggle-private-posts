# Toggle Private Posts

WP Admin Bar control to toggle private posts in current view.

## Filters

### `toggle_private_posts/label/hide`

WP Admin Bar node label when all posts are shown.

**Default:**

```php
$title = 'Hide Private Posts';
```

### `toggle_private_posts/label/show`

Label when private posts are hidden.

**Default:**

```php
$title = 'Show All Posts';
```

### `toggle_private_posts/is_valid_location`

Whether the WP Admin Bar node should be shown in the current view.

**Type:** Boolean