<nav class="social-links">
    <ul>
        <?php
        $social_profiles = array(
            'facebook' => __('Facebook', 'personal-branding-child'),
            'twitter' => __('Twitter', 'personal-branding-child'),
            'linkedin' => __('LinkedIn', 'personal-branding-child'),
            'threads' => __('Threads', 'personal-branding-child'),
        );

        foreach ($social_profiles as $slug => $label) {
            $url = get_theme_mod($slug . '_url');
            if ($url) {
                echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
            }
        }
        ?>
    </ul>
</nav>
