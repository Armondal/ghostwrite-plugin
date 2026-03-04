<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Ghostwrite_Admin {

    public function __construct() {
        // Register the menu page in the dashboard
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }

    public function add_admin_menu() {
        add_menu_page(
            'Ghostwrite AI Tester',
            'Ghostwrite',
            'manage_options',
            'ghostwrite-tester',
            array( $this, 'render_admin_page' ),
            'dashicons-admin-customizer',
            20
        );
    }

    public function render_admin_page() {
        $message = '';

        // Check if the form was submitted and verify the security nonce
        if ( isset( $_POST['ghostwrite_submit'] ) && check_admin_referer( 'ghostwrite_test_action', 'ghostwrite_nonce' ) ) {
            
            // Format the inputs from the form
            $inputs = array(
                'author_details'  => sanitize_textarea_field( $_POST['author_details'] ?? '' ),
                'long_context'    => sanitize_textarea_field( $_POST['long_context'] ?? '' ),
                'external_urls'   => explode( "\n", sanitize_textarea_field( $_POST['external_urls'] ?? '' ) ),
                'past_posts'      => explode( "\n", sanitize_textarea_field( $_POST['past_posts'] ?? '' ) ),
                'reference_image' => esc_url_raw( $_POST['reference_image'] ?? '' )
            );

            // Trigger the core logic directly for testing
            $core = new Ghostwrite_Core();
            $result = $core->generate_post_content( $inputs );

            if ( is_wp_error( $result ) ) {
                $message = '<div class="notice notice-error"><p>Error: ' . esc_html( $result->get_error_message() ) . '</p></div>';
            } else {
                $message = '<div class="notice notice-success"><p>Success! Draft generated. Post ID: ' . intval( $result ) . ' <a href="' . get_edit_post_link( $result ) . '">Edit Post</a></p></div>';
            }
        }

        // Render the form HTML
        ?>
        <div class="wrap">
            <h1>Test Ghostwrite Ability</h1>
            <?php echo $message; ?>
            <form method="post" action="">
                <?php wp_nonce_field( 'ghostwrite_test_action', 'ghostwrite_nonce' ); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="author_details">Author Details</label></th>
                        <td><textarea name="author_details" id="author_details" rows="3" class="regular-text" required></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="long_context">Context / Instructions</label></th>
                        <td><textarea name="long_context" id="long_context" rows="4" class="regular-text" required></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="external_urls">External URLs (One per line)</label></th>
                        <td><textarea name="external_urls" id="external_urls" rows="3" class="regular-text"></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="past_posts">Past Posts Content (One per line)</label></th>
                        <td><textarea name="past_posts" id="past_posts" rows="3" class="regular-text"></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="reference_image">Reference Image URL</label></th>
                        <td><input type="url" name="reference_image" id="reference_image" class="regular-text"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="ghostwrite_submit" id="submit" class="button button-primary" value="Generate Draft Post">
                </p>
            </form>
        </div>
        <?php
    }
}