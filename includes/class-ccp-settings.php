<?php
if (!defined('ABSPATH'))
    exit;

class CCP_Settings
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    public function menu()
    {
        add_options_page(
            'Custom Cursor',
            'Custom Cursor',
            'manage_options',
            'ccp-settings',
            [$this, 'settings_page']
        );
    }

    public function register_settings()
    {
        register_setting('ccp_group', 'ccp_enable');
        register_setting('ccp_group', 'ccp_cursor_image');
        register_setting('ccp_group', 'ccp_cursor_size');

        add_option('ccp_enable', 1);
        add_option('ccp_cursor_size', 32);
    }

    /**
     * Admin assets (Media uploader)
     */
    public function enqueue_admin_assets($hook)
    {

        if ($hook !== 'settings_page_ccp-settings')
            return;

        wp_enqueue_media();

        wp_enqueue_script(
            'ccp-admin',
            CCP_URL . 'assets/js/ccp-admin.js',
            ['jquery'],
            '1.0.0',
            true
        );
    }

    /**
     * Frontend assets
     */
    public function enqueue_frontend_assets()
    {

        if (!get_option('ccp_enable'))
            return;
        if (is_admin())
            return;

        wp_enqueue_style(
            'ccp-style',
            CCP_URL . 'assets/css/ccp-style.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'ccp-script',
            CCP_URL . 'assets/js/ccp-script.js',
            [],
            '1.0.0',
            true
        );

        wp_localize_script('ccp-script', 'CCP_DATA', [
            'image' => esc_url(get_option('ccp_cursor_image')),
            'size' => (int) get_option('ccp_cursor_size', 32),
        ]);
    }

    public function settings_page()
    {
        ?>
        <div class="wrap">
            <h1>Custom Cursor Settings</h1>

            <form method="post" action="options.php">
                <?php settings_fields('ccp_group'); ?>

                <table class="form-table">

                    <tr>
                        <th>Enable Custom Cursor</th>
                        <td>
                            <input type="checkbox" name="ccp_enable" value="1" <?php checked(1, get_option('ccp_enable')); ?>>
                        </td>
                    </tr>


                    <tr>
                        <th>Cursor Image</th>
                        <td>

                            <!-- Hidden input (stores image URL) -->
                            <input type="hidden" id="ccp_cursor_image" name="ccp_cursor_image"
                                value="<?php echo esc_attr(get_option('ccp_cursor_image')); ?>">

                            <button type="button" class="button" id="ccp_upload_button">
                                <?php echo get_option('ccp_cursor_image') ? 'Change Image' : 'Upload Image'; ?>
                            </button>

                            <p class="description">
                                Upload or select a PNG or SVG image with transparent background.
                            </p>

                            <!-- Live Preview -->
                            <div id="ccp-image-preview" style="margin-top:12px;">
                                <?php if (get_option('ccp_cursor_image')): ?>
                                    <img src="<?php echo esc_url(get_option('ccp_cursor_image')); ?>"
                                        style="max-width:80px; height:auto; display:block;">
                                <?php else: ?>
                                    <span style="color:#777;">No image selected</span>
                                <?php endif; ?>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <th>Cursor Size (px)</th>
                        <td>
                            <input type="number" name="ccp_cursor_size"
                                value="<?php echo esc_attr(get_option('ccp_cursor_size')); ?>" min="8" max="128">
                        </td>
                    </tr>

                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
