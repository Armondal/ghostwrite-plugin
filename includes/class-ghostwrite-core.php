<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Ghostwrite_Core {

    public function __construct() {
        // Connect our registration method to the WP 7.0 Abilities API
        add_action( 'wp_abilities_api_init', array( $this, 'register_ai_ability' ) );
    }

    public function register_ai_ability() {
        wp_register_ability( 'ghostwrite/generate-post', array(
            'type'        => 'text-generation',
            'description' => 'Generates a personalized post based on author details, past writing, and external references.',
            'inputs'      => array(
                'author_details' => array(
                    'type'        => 'string',
                    'description' => 'The biographical details and writing style guidelines for the author.'
                ),
                'external_urls' => array(
                    'type'        => 'array',
                    'description' => 'A list of website URLs to extract factual references from.'
                ),
                'past_posts' => array(
                    'type'        => 'array',
                    'description' => 'A collection of the author\'s previous posts to establish their writing style.'
                ),
                'long_context' => array(
                    'type'        => 'string',
                    'description' => 'Additional instructions, background information, or specific topics to cover.'
                ),
                'reference_image' => array(
                    'type'        => 'string',
                    'description' => 'The URL or data URI of an image to analyze and include in the post.'
                )
            ),
            'callback'    => array( $this, 'generate_post_content' )
        ) );
    }
    
    public function generate_post_content( $inputs ) {
        // This is where we will handle the logic and send the prompt to the API later
    }
}