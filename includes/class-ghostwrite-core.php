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
        // Extract the data safely
        $author_details  = $inputs['author_details'] ?? '';
        $external_urls   = $inputs['external_urls'] ?? array();
        $past_posts      = $inputs['past_posts'] ?? array();
        $long_context    = $inputs['long_context'] ?? '';
        $reference_image = $inputs['reference_image'] ?? '';

        // Next: Construct the prompt string
        $system_prompt = "You are an expert ghostwriter. Write a post adhering to these author details: {$author_details}. Here is the specific context and instructions: {$long_context}.";

        $response = wp_ai_generate_text( array(
            'prompt' => $system_prompt,
            'images' => $reference_image ? array( $reference_image ) : array()
        ) );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        return $response['text'];
    }
}