<?php
/*
Plugin Name: StatsFC Fixtures
Plugin URI: https://statsfc.com/fixtures
Description: StatsFC Fixtures
Version: 3.1.0
Author: Will Woodward
Author URI: https://willjw.co.uk
License: GPL2
*/

/*  Copyright 2020  Will Woodward  (email : will@willjw.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('STATSFC_FIXTURES_ID',      'StatsFC_Fixtures');
define('STATSFC_FIXTURES_NAME',    'StatsFC Fixtures');
define('STATSFC_FIXTURES_VERSION', '3.1.0');

/**
 * Adds StatsFC widget.
 */
class StatsFC_Fixtures extends WP_Widget
{
    public $isShortcode = false;

    protected static $count = 0;

    private static $defaults = array(
        'title'       => '',
        'key'         => '',
        'competition' => '',
        'group'       => '',
        'team'        => '',
        'season'      => '',
        'from'        => '',
        'to'          => '',
        'limit'       => 0,
        'highlight'   => '',
        'show_badges' => true,
        'show_dates'  => true,
        'timezone'    => 'Europe/London',
        'default_css' => true,
        'omit_errors' => false,
    );

    private static $whitelist = array(
        'competition',
        'group',
        'team',
        'season',
        'from',
        'to',
        'limit',
        'highlight',
        'showBadges',
        'showDates',
        'timezone',
        'omitErrors',
        'lang',
    );

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(STATSFC_FIXTURES_ID, STATSFC_FIXTURES_NAME, array('description' => 'StatsFC Fixtures'));
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $instance    = wp_parse_args((array) $instance, self::$defaults);
        $title       = strip_tags($instance['title']);
        $key         = strip_tags($instance['key']);
        $competition = strip_tags($instance['competition']);
        $group       = strip_tags($instance['group']);
        $team        = strip_tags($instance['team']);
        $season      = strip_tags($instance['season']);
        $from        = strip_tags($instance['from']);
        $to          = strip_tags($instance['to']);
        $limit       = strip_tags($instance['limit']);
        $highlight   = strip_tags($instance['highlight']);
        $show_badges = strip_tags($instance['show_badges']);
        $show_dates  = strip_tags($instance['show_dates']);
        $timezone    = strip_tags($instance['timezone']);
        $default_css = strip_tags($instance['default_css']);
        $omit_errors = strip_tags($instance['omit_errors']);
        ?>
        <p>
            <label>
                <?php _e('Title', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Key', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo esc_attr($key); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Competition', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('competition'); ?>" type="text" value="<?php echo esc_attr($competition); ?>" placeholder="e.g., EPL, CHP, FAC">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Group', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('group'); ?>" type="text" value="<?php echo esc_attr($group); ?>" placeholder="Optional. E.g., Group A, Group B">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Team', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('team'); ?>" type="text" value="<?php echo esc_attr($team); ?>" placeholder="e.g., Liverpool, Manchester City">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Season', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('season'); ?>" type="text" value="<?php echo esc_attr($season); ?>" placeholder="e.g., 2016/2017">
            </label>
        </p>
        <p>
            <label>
                <?php _e('From', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('from'); ?>" type="text" value="<?php echo esc_attr($from); ?>" placeholder="e.g., <?php echo date('Y-m-d'); ?>, today">
            </label>
        </p>
        <p>
            <label>
                <?php _e('To', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('to'); ?>" type="text" value="<?php echo esc_attr($to); ?>" placeholder="e.g., <?php echo date('Y-m-d', strtotime('+2 weeks')); ?>, +2 weeks, next Monday">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Limit', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo esc_attr($limit); ?>" min="0" max="99"><br>
                <small>Applies to single team only. Choose '0' for all fixtures.</small>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Highlight team', STATSFC_FIXTURES_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('highlight'); ?>" type="text" value="<?php echo esc_attr($highlight); ?>" placeholder="e.g., Liverpool, Manchester City">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show badges?', STATSFC_FIXTURES_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_badges'); ?>"<?php echo ($show_badges == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show dates?', STATSFC_FIXTURES_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_dates'); ?>"<?php echo ($show_dates == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Timezone', STATSFC_FIXTURES_ID); ?>
                <select class="widefat" name="<?php echo $this->get_field_name('timezone'); ?>">
                    <?php
                    $zones = timezone_identifiers_list();

                    foreach ($zones as $zone) {
                        $selected = ($zone == $timezone ? ' selected' : '');

                        echo '<option value="' . esc_attr($zone) . '"' . $selected . '>' . esc_attr($zone) . '</option>' . PHP_EOL;
                    }
                    ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Use default styles?', STATSFC_FIXTURES_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('default_css'); ?>"<?php echo ($default_css == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Omit error messages?', STATSFC_FIXTURES_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('omit_errors'); ?>"<?php echo ($omit_errors == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance                = $old_instance;
        $instance['title']       = strip_tags($new_instance['title']);
        $instance['key']         = strip_tags($new_instance['key']);
        $instance['competition'] = strip_tags($new_instance['competition']);
        $instance['group']       = strip_tags($new_instance['group']);
        $instance['team']        = strip_tags($new_instance['team']);
        $instance['season']      = strip_tags($new_instance['season']);
        $instance['from']        = strip_tags($new_instance['from']);
        $instance['to']          = strip_tags($new_instance['to']);
        $instance['limit']       = strip_tags($new_instance['limit']);
        $instance['highlight']   = strip_tags($new_instance['highlight']);
        $instance['show_badges'] = strip_tags($new_instance['show_badges']);
        $instance['show_dates']  = strip_tags($new_instance['show_dates']);
        $instance['timezone']    = strip_tags($new_instance['timezone']);
        $instance['default_css'] = strip_tags($new_instance['default_css']);
        $instance['omit_errors'] = strip_tags($new_instance['omit_errors']);

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        $title       = apply_filters('widget_title', (array_key_exists('title', $instance) ? $instance['title'] : ''));
        $unique_id   = ++static::$count;
        $key         = (array_key_exists('key', $instance) ? $instance['key'] : '');
        $referer     = (array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '');
        $default_css = (array_key_exists('default_css', $instance) && filter_var($instance['default_css'], FILTER_VALIDATE_BOOLEAN));

        $options = array(
            'competition' => (array_key_exists('competition', $instance) ? $instance['competition'] : ''),
            'group'       => (array_key_exists('group', $instance) ? $instance['group'] : ''),
            'team'        => (array_key_exists('team', $instance) ? $instance['team'] : ''),
            'season'      => (array_key_exists('season', $instance) ? $instance['season'] : ''),
            'from'        => (array_key_exists('from', $instance) ? $instance['from'] : ''),
            'to'          => (array_key_exists('to', $instance) ? $instance['to'] : ''),
            'limit'       => (array_key_exists('limit', $instance) ? (int) $instance['limit'] : 0),
            'highlight'   => (array_key_exists('highlight', $instance) ? $instance['highlight'] : ''),
            'showBadges'  => (array_key_exists('show_badges', $instance) && filter_var($instance['show_badges'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'showDates'   => (array_key_exists('show_dates', $instance) && filter_var($instance['show_dates'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'timezone'    => (array_key_exists('timezone', $instance) ? $instance['timezone'] : ''),
            'omitErrors'  => (array_key_exists('omit_errors', $instance) && isset($instance['omit_errors']) && filter_var($instance['omit_errors'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'lang'        => substr(get_bloginfo('language'), 0, 2),
        );

        $html = '';

        if (isset($before_widget)) {
            $html .= $before_widget;
        }

        if (isset($before_title)) {
            $html .= $before_title;
        }

        $html .= $title;

        if (isset($after_title)) {
            $html .= $after_title;
        }

        $html .= '<div id="statsfc-fixtures-' . $unique_id . '"></div>' . PHP_EOL;

        if (isset($after_widget)) {
            $html .= $after_widget;
        }

        // Enqueue CSS
        if ($default_css) {
            wp_enqueue_style(STATSFC_FIXTURES_ID, plugins_url('fixtures.css', __FILE__), null, STATSFC_FIXTURES_VERSION);
        }

        // Enqueue base JS
        wp_enqueue_script(STATSFC_FIXTURES_ID, plugins_url('fixtures.js', __FILE__), array('jquery'), STATSFC_FIXTURES_VERSION, true);

        // Enqueue widget JS
        $object = 'statsfc_fixtures_' . $unique_id;

        $script  = '<script>' . PHP_EOL;
        $script .= 'var ' . $object . ' = new StatsFC_Fixtures(' . json_encode($key) . ');' . PHP_EOL;
        $script .= $object . '.referer = ' . json_encode($referer) . ';' . PHP_EOL;

        foreach (static::$whitelist as $parameter) {
            if (! array_key_exists($parameter, $options)) {
                continue;
            }

            $script .= $object . '.' . $parameter . ' = ' . json_encode($options[$parameter]) . ';' . PHP_EOL;
        }

        $script .= $object . '.display("statsfc-fixtures-' . $unique_id . '");' . PHP_EOL;
        $script .= '</script>';

        add_action('wp_print_footer_scripts', function () use ($script) {
            echo $script;
        });

        if ($this->isShortcode) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function shortcode($atts)
    {
        $args = shortcode_atts(self::$defaults, $atts);

        $widget              = new self;
        $widget->isShortcode = true;

        return $widget->widget(array(), $args);
    }
}

// Register StatsFC widget
add_action('widgets_init', function () {
    register_widget(STATSFC_FIXTURES_ID);
});

add_shortcode('statsfc-fixtures', STATSFC_FIXTURES_ID . '::shortcode');
