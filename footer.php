<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <?php
                // Displaying social media links from the Customizer
                $social_profiles = array(
                    'facebook' => __('Facebook', 'personal-branding-child'),
                    'twitter' => __('Twitter', 'personal-branding-child'),
                    'linkedin' => __('LinkedIn', 'personal-branding-child'),
                    'threads' => __('Threads', 'personal-branding-child'),
                );

                echo '<nav class="social-links">';
                echo '<ul>';
                foreach ($social_profiles as $slug => $label) {
                    $url = get_theme_mod($slug . '_url');
                    if ($url) {
                        echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                    }
                }
                echo '</ul>';
                echo '</nav>';
                ?>
            </div>
        </div>
    </div>
</footer>
