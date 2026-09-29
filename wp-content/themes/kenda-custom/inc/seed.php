<?php
/**
 * Theme activation: default content, media, menus, front page.
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_switch_theme', 'kenda_theme_seed_content' );

/**
 * Import file from theme assets into Media Library.
 */
function kenda_import_theme_asset( string $relative_path, string $title ): int {
	$path = KENDA_THEME_DIR . '/' . ltrim( $relative_path, '/' );
	if ( ! file_exists( $path ) ) {
		return 0;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'meta_key'       => '_kenda_asset_path',
			'meta_value'     => $relative_path,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( basename( $path ), null, (string) file_get_contents( $path ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( basename( $path ), null );
	$attach_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => $title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	if ( is_wp_error( $attach_id ) ) {
		return 0;
	}
	wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $upload['file'] ) );
	update_post_meta( $attach_id, '_kenda_asset_path', $relative_path );
	return (int) $attach_id;
}

function kenda_theme_seed_content(): void {
	if ( get_option( 'kenda_theme_seeded' ) ) {
		return;
	}

	$video_id    = kenda_import_theme_asset( 'assets/videos/hero-campaign.mp4', 'Hero Campaign Video' );
	$poster_id   = kenda_import_theme_asset( 'assets/images/kc-skyline.png', 'KC Skyline Poster' );
	$portrait_id = kenda_import_theme_asset( 'assets/images/kenda-portrait.png', 'Kenda Portrait' );
	$vision_id   = kenda_import_theme_asset( 'assets/images/kc-community.jpg', 'Kansas City Community' );
	$logo_id     = kenda_import_theme_asset( 'assets/images/campaign-logo-shield.png', 'Campaign Logo' );

	update_option(
		'kenda_site_settings',
		array(
			'site_name'              => 'Kenda Tomes McClain 4 KC',
			'contact_email'          => 'kenda@KendaTomesMcClain4KC.com',
			'contact_phone'          => '816-829-0177',
			'donation_url'           => 'https://donate.stripe.com/7sY28s1m9gI16CtaFPd7q00',
			'header_cta_text'        => 'Donate',
			'header_cta_url'         => 'https://donate.stripe.com/7sY28s1m9gI16CtaFPd7q00',
			'facebook_url'           => 'https://www.facebook.com/kendatomesmcclain4kc',
			'instagram_url'          => 'https://www.instagram.com/kendatomesmcclain4kc',
			'twitter_url'            => 'https://www.x.com/kendatomesmcclain4kc',
			'footer_disclaimer'      => 'Paid for by Kenda Tomes McClain 4 KC — Shelley Dillon, Treasurer',
			'copyright_text'         => 'Copyright © 2026 Kenda Tomes McClain 4 KC - All Rights Reserved.',
			'newsletter_heading'     => 'Join the Campaign!',
			'newsletter_description' => 'Stay informed — join Kenda\'s community today.',
		)
	);

	update_option(
		'kenda_homepage_settings',
		array(
			'hero_elect'          => 'ELECT',
			'hero_title'          => 'Kenda Tomes McClain',
			'hero_subtitle'       => 'Campaign Strategy, Service Delivery Timeline & Proposal',
			'hero_eyebrow'        => 'for Mayor of Kansas City, Missouri',
			'hero_credit_line'    => 'Prepared by JPP Consulting',
			'hero_services_line'  => 'AI-Based Political Consulting & Social Sentiment-Driven Campaign Deliverables',
			'hero_website_line'   => 'kendatomesmcclain4kc.com',
			'hero_description'    => '',
			'hero_video'          => $video_id,
			'hero_poster'         => $poster_id,
			'hero_primary_text'   => 'Get Involved',
			'hero_primary_url'    => '#get-involved',
			'hero_secondary_text' => 'Donate',
			'hero_secondary_url'  => '#support',
			'intro_eyebrow'       => 'Voters Matter',
			'intro_heading'       => 'Leadership for ALL of Kansas City',
			'intro_lead'          => 'As Kansas Citians, we deserve leadership that reflects our values, from the grassroots to public companies.',
			'intro_body'          => 'We need to change the atmosphere in Kansas City. The people we have running this city should reflect the values of the voters — family over special interest, freedom from violence, organic neighborhood development, and accountability for every dollar spent.',
			'about_eyebrow'       => 'About Kenda',
			'about_heading'       => 'A Kansas Citian with heart and mind for the people',
			'about_body'          => "Kenda has always had an interest in public service. After she graduated from the University of Michigan in 1982, she moved to Chicago. While living in Chicago, she served as a committee organizer for several years.\n\nKenda has established herself as a leading authority in corporate finance and structured finance transactions. As a senior partner leading the structured finance practice since 2008, she has played a pivotal role in advising clients on complex legal matters.\n\nKenda Tomes McClain has worked hard her entire life to build her career and serve her community. Kenda has served her community in Kansas City for over 30 years through church leadership, neighborhood outreach, school volunteer roles, and service on boards including Neighborhood Housing Services and Alphapointe School For the Blind.",
			'about_image'         => $portrait_id,
			'about_facts'         => "Juris Doctor — Chicago-Kent College of Law\nBachelor's — University of Michigan (accounting focus)\nNamed among Ingram's Most Influential Women Lawyers in Greater Kansas City (2019)\nAmerican College of Real Estate Lawyers Fellow (2019–present)",
			'experience_eyebrow'  => 'Leadership & Experience',
			'experience_heading'  => 'A Track Record of Public Service',
			'experience_intro'    => '30+ years in finance and civic leadership — guiding multi-billion-dollar transactions while serving Kansas City through schools, churches, and community boards.',
			'priorities_eyebrow'  => 'Our Platform',
			'priorities_heading'  => 'Public Safety · Infrastructure · Economic Opportunity',
			'priorities_intro'    => 'Kansas City needs leadership focused on the basics voters expect — safer neighborhoods, infrastructure that works, and accountable development.',
			'vision_eyebrow'      => 'Kansas City Vision',
			'vision_heading'      => 'The Heart of Our Mission',
			'vision_body'         => "Yes, we are all different in many ways but fundamentally Kansas Citizens all want the same thing. We want our votes to matter. We want safe and affordable neighborhoods, affordable homeownership, freedom from violence, freedom from oppression, an excellent education for our children and equal opportunity to prosper and live the American dream.\n\nKenda says, \"I love Kansas City; I raised my family here and built my career here. I want the people of Kansas City and this city to have the opportunity to reach their potential.\"",
			'vision_image'        => $vision_id,
			'involved_eyebrow'    => 'Get Involved',
			'involved_heading'    => 'Consider volunteering for our campaign',
			'involved_body'       => 'We need VOLUNTEERS for our campaign — people who can walk doors and have conversations with voters, drivers, phone bankers, yard sign delivery, and poll greeters on election day. If you can spare a few hours, we are willing to train you.',
			'involved_cta_text'   => 'Contact the Campaign',
			'involved_cta_url'    => '#contact',
			'cta_eyebrow'         => 'Support',
			'cta_heading'         => 'Support a CHANGE in LEADERSHIP in Kansas City',
			'cta_body'            => "We need your help to power our campaign for the people to VICTORY! Click the DONATE NOW link below or use the QR code.\n\nLet's work together for a better Kansas City.",
			'cta_button_text'     => 'Donate Now',
			'cta_button_url'      => 'https://donate.stripe.com/7sY28s1m9gI16CtaFPd7q00',
			'contact_eyebrow'     => 'Contact',
			'contact_heading'     => 'Connect with Us',
			'contact_body'        => 'We love Kansas City, so feel free to reach out.',
		)
	);

	$experiences = array(
		array(
			'year'  => '1982',
			'title' => 'University of Michigan',
			'org'   => 'Education',
			'body'  => 'Graduated with a bachelor\'s degree in general studies with a focus in accounting. Moved to Chicago and served as a committee organizer for several years.',
		),
		array(
			'year'  => 'Law School',
			'title' => 'Chicago-Kent College of Law',
			'org'   => 'Juris Doctor',
			'body'  => 'Earned a Juris Doctor and began a career advising clients on complex tax and securities matters.',
		),
		array(
			'year'  => '2008–Present',
			'title' => 'Structured Finance Leadership',
			'org'   => 'Corporate Finance',
			'body'  => 'Senior partner leading structured finance — advising on multi-billion-dollar transactions, CMBS, asset-backed deals, and commercial loan workouts. Named among Ingram\'s Most Influential Women Lawyers in Greater Kansas City (2019).',
		),
		array(
			'year'  => 'Community',
			'title' => '30+ Years Serving Kansas City',
			'org'   => 'Civic Leadership',
			'body'  => 'Board service for Neighborhood Housing Services and Alphapointe School for the Blind; school and church leadership; CRE Council, MBA, and American College of Real Estate Lawyers fellow.',
		),
	);

	$order = 1;
	foreach ( $experiences as $row ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'kenda_experience',
				'post_status'  => 'publish',
				'post_title'   => $row['title'],
				'post_content' => $row['body'],
				'menu_order'   => $order,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, 'experience_year', $row['year'] );
			update_post_meta( $post_id, 'experience_organization', $row['org'] );
		}
		++$order;
	}

	$priorities = array(
		array(
			'num'   => '01',
			'title' => 'Public Safety',
			'short' => 'Safer neighborhoods, faster response, community trust, and support for families affected by violence.',
			'body'  => 'Kenda supports cooperation between local, county, state and federal law enforcement, neighborhood associations, and citizens to help stop violence before it begins and to get to the facts to bring justice for victims of crime and to those who commit crimes.',
		),
		array(
			'num'   => '02',
			'title' => 'Infrastructure',
			'short' => 'Reliable basic services, roads, water, transit, and neighborhood-level accountability.',
			'body'  => 'We need infrastructure that works. We must invest in the "basics"—fixing our roads and bridges, improving public transit, garbage collection, snow removal and ensuring reliable city services for every neighborhood.',
		),
		array(
			'num'   => '03',
			'title' => 'Economic Opportunity',
			'short' => 'Finance expertise applied to jobs, small business, cost of living, and accountable development.',
			'body'  => 'We need a comprehensive plan for Kansas City involving the Northland, the East, and South Kansas City. The city needs to reduce regulations and red tape for homeowners and developers and streamline inspection and permit approval times.',
		),
	);

	$order = 1;
	foreach ( $priorities as $row ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'kenda_priority',
				'post_status'  => 'publish',
				'post_title'   => $row['title'],
				'post_content' => $row['body'],
				'menu_order'   => $order,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, 'priority_number', $row['num'] );
			update_post_meta( $post_id, 'priority_short_description', $row['short'] );
		}
		++$order;
	}

	$home_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_content' => '',
		)
	);

	if ( $home_id && ! is_wp_error( $home_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	if ( $logo_id ) {
		set_theme_mod( 'custom_logo', $logo_id );
	}

	$menu_id = wp_create_nav_menu( 'Primary' );
	if ( ! is_wp_error( $menu_id ) ) {
		$links = array(
			array( 'About', '#about' ),
			array( 'Experience', '#experience' ),
			array( 'Priorities', '#priorities' ),
			array( 'Vision', '#vision' ),
			array( 'Get Involved', '#get-involved' ),
			array( 'Contact', '#contact' ),
		);
		foreach ( $links as $i => $link ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'  => $link[0],
					'menu-item-url'    => $link[1],
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
					'menu-item-position' => $i + 1,
				)
			);
		}
		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = (int) $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'kenda_theme_seeded', 1 );
}
