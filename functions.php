// Enabling custom logo support

add_theme_support('custom-logo');

// Enabling custom color scheme support
add_theme_support(
    'editor-color-palette',
    array(
        array(
            'name' => __('Primary Color', 'personal-branding-child'),
            'slug' => 'primary',
            'color' => '#007bff',
        ),
    )
);

// Enqueueing the customizer scripts and styles

function personal_branding_customizer_assets() {
    wp_enqueue_script(
        'personal-branding-customizer',
        get_stylesheet_directory_uri() . '/js/customizer.js',
        array('jquery', 'customize-preview'),
        '1.0',
        true
    );
}
add_action('customize_preview_init', 'personal_branding_customizer_assets');

// Adding customizer settings for the primary color
function personal_branding_customizer_settings($wp_customize) {
    $wp_customize->add_setting('primary_color', array(
        'default' => '#007bff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'personal-branding-child'),
        'section' => 'colors',
    )));
}
add_action('customize_register', 'personal_branding_customizer_settings');

// Applying primary color to relevant elements

function personal_branding_apply_customizer_styles() {
    $primary_color = get_theme_mod('primary_color', '#007bff');
    ?>
    <style type="text/css">
        a,
        .primary-color {
            color: <?php echo esc_attr($primary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'personal_branding_apply_customizer_styles');

function personal_branding_social_media_settings($wp_customize) {
  // Social Media Section here
  $wp_customize->add_section('social_media', array(
      'title' => __('Social Media Profiles', 'personal-branding-child'),
      'priority' => 120,
  ));

  // Social Media URLs here
  $social_profiles = array(
      'facebook' => __('Facebook', 'personal-branding-child'),
      'twitter' => __('Twitter', 'personal-branding-child'),
      'linkedin' => __('LinkedIn', 'personal-branding-child'),
      'threads' => __('Threads', 'personal-branding-child'),
  );

  foreach ($social_profiles as $slug => $label) {
      $wp_customize->add_setting($slug . '_url', array(
          'default' => '',
          'sanitize_callback' => 'esc_url_raw',
      ));

      $wp_customize->add_control($slug . '_url', array(
          'label' => $label,
          'section' => 'social_media',
          'type' => 'url',
      ));
  }
}
add_action('customize_register', 'personal_branding_social_media_settings');

function personal_branding_resume_post_type() {
  register_post_type('resume', array(
      'labels' => array(
          'name' => __('Resumes', 'personal-branding-child'),
          'singular_name' => __('Resume', 'personal-branding-child'),
      ),
      'public' => true,
      'menu_icon' => 'dashicons-id',
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail'),
  ));
}
add_action('init', 'personal_branding_resume_post_type');

// Adding custom meta boxes for resume/CV details
function personal_branding_resume_meta_boxes() {
  add_meta_box(
      'personal_details_box',
      __('Personal Details', 'personal-branding-child'),
      'personal_branding_render_personal_details_meta_box',
      'resume',
      'normal',
      'high'
  );

  add_meta_box(
      'work_experience_box',
      __('Work Experience', 'personal-branding-child'),
      'personal_branding_render_work_experience_meta_box',
      'resume',
      'normal',
      'high'
  );

  add_meta_box(
      'education_box',
      __('Education', 'personal-branding-child'),
      'personal_branding_render_education_meta_box',
      'resume',
      'normal',
      'high'
  );
}
add_action('add_meta_boxes', 'personal_branding_resume_meta_boxes');

// Callback function to render the Personal Details meta box
function personal_branding_render_personal_details_meta_box($post) {
  // Getting the saved data
  $name = get_post_meta($post->ID, '_personal_branding_name', true);
  $email = get_post_meta($post->ID, '_personal_branding_email', true);
  $phone = get_post_meta($post->ID, '_personal_branding_phone', true);
  ?>
  <label for="personal-branding-name"><?php _e('Name:', 'personal-branding-child'); ?></label>
  <input type="text" id="personal-branding-name" name="personal_branding_name" value="<?php echo esc_attr($name); ?>" />

  <label for="personal-branding-email"><?php _e('Email:', 'personal-branding-child'); ?></label>
  <input type="email" id="personal-branding-email" name="personal_branding_email" value="<?php echo esc_attr($email); ?>" />

  <label for="personal-branding-phone"><?php _e('Phone:', 'personal-branding-child'); ?></label>
  <input type="text" id="personal-branding-phone" name="personal_branding_phone" value="<?php echo esc_attr($phone); ?>" />
  <?php
}

// Callback function to render the Work Experience meta box
function personal_branding_render_work_experience_meta_box($post) {
  // Getting the saved data
  $work_experience = get_post_meta($post->ID, '_personal_branding_work_experience', true);
  ?>
  <textarea id="personal-branding-work-experience" name="personal_branding_work_experience" rows="5"><?php echo esc_textarea($work_experience); ?></textarea>
  <?php
}

// Callback function to render the Education meta box
function personal_branding_render_education_meta_box($post) {
  // Getting the saved data
  $education = get_post_meta($post->ID, '_personal_branding_education', true);
  ?>
  <textarea id="personal-branding-education" name="personal_branding_education" rows="5"><?php echo esc_textarea($education); ?></textarea>
  <?php
}

// This saves the custom meta box data when the post is saved/updated
function personal_branding_save_resume_meta($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return;

  if (isset($_POST['post_type']) && 'resume' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id))
          return;
  } else {
      if (!current_user_can('edit_post', $post_id))
          return;
  }

  // Save Personal Details too
  if (isset($_POST['personal_branding_name'])) {
      update_post_meta($post_id, '_personal_branding_name', sanitize_text_field($_POST['personal_branding_name']));
  }

  if (isset($_POST['personal_branding_email'])) {
      update_post_meta($post_id, '_personal_branding_email', sanitize_email($_POST['personal_branding_email']));
  }

  if (isset($_POST['personal_branding_phone'])) {
      update_post_meta($post_id, '_personal_branding_phone', sanitize_text_field($_POST['personal_branding_phone']));
  }

  // Save Work Experience
  if (isset($_POST['personal_branding_work_experience'])) {
      update_post_meta($post_id, '_personal_branding_work_experience', sanitize_textarea_field($_POST['personal_branding_work_experience']));
  }

  // Save Education
  if (isset($_POST['personal_branding_education'])) {
      update_post_meta($post_id, '_personal_branding_education', sanitize_textarea_field($_POST['personal_branding_education']));
  }
}
add_action('save_post_resume', 'personal_branding_save_resume_meta');

// Enqueueing the custom CSS file

function personal_branding_enqueue_styles() {
  wp_enqueue_style(
      'personal-branding-style',
      get_stylesheet_directory_uri() . '/style.css',
      array(),
      '1.0'
  );
}
add_action('wp_enqueue_scripts', 'personal_branding_enqueue_styles');

