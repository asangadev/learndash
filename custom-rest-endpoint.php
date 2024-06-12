<?php

// Custom endpoint for LearnDash: sfwd-courses > sfwd-courses-custom
function register_custom_rest_endpoint() {
    // Check if LearnDash and its required classes are available
    if ( class_exists( 'LD_REST_Courses_Controller_V1' ) && class_exists( 'LearnDash_Settings_Section' ) ) {

        // Create a new custom controller class
        class LD_REST_Courses_Custom_Controller_V1 extends LD_REST_Posts_Controller_V1 {
            // Define namespace and REST base for your custom endpoint
            public function __construct( $post_type = '' ) {
                $this->post_type  = 'sfwd-courses';
                $this->taxonomies = array();

                parent::__construct( $this->post_type );
                $this->namespace = LEARNDASH_REST_API_NAMESPACE . '/' . $this->version;
                $this->rest_base = 'sfwd-courses-custom'; // Change this to your desired REST base
            }

            // Register routes for your custom endpoint
            public function register_routes() {
                $collection_params = $this->get_collection_params();

                register_rest_route(
                    $this->namespace,
                    '/' . $this->rest_base,
                    array(
                        array(
                            'methods'             => WP_REST_Server::READABLE,
                            'callback'            => array( $this, 'get_items' ),
                            'args'                => $this->get_collection_params(),
                        ),
                    )
                );
            }

        }

        // Register your custom controller
        $custom_controller = new LD_REST_Courses_Custom_Controller_V1();
        $custom_controller->register_routes();
    }
}
add_action( 'rest_api_init', 'register_custom_rest_endpoint' );