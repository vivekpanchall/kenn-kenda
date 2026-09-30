<?php
/**
 * PPT deck helpers and default slide content (V2-McCLAIN).
 *
 * @package Kenda_Custom
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default slide content extracted from the proposal deck.
 *
 * @return array<string, array<string, mixed>>
 */
function kenda_ppt_default_slides(): array {
	return array(
		'slide_02' => array(
			'eyebrow'       => __( 'Primary proposal only: April 2027 nonpartisan mayoral primary', 'kenda-custom' ),
			'heading'       => __( 'Thank You, Kenda — Scope & Campaign Window', 'kenda-custom' ),
			'intro'         => __( 'Thank you for the opportunity', 'kenda-custom' ),
			'bullets'       => "• This proposal is built to carry a disciplined message Kansas City can trust.\n• The campaign will position Kenda as a fiscally serious leader focused on families, accountability, and results.\n• Every recommendation is designed to reach voters where they live, scroll, stream, and gather.",
			'scope_title'   => __( 'Scope Note', 'kenda-custom' ),
			'scope_bullets' => "• Primary campaign deliverables only.\n• Kansas City's nonpartisan municipal primary is expected in April 2027.\n• Working planning date: April 6, 2027, pending the official Election Board calendar.\n• A June 2027 runoff/general election proposal will be prepared separately if Kenda advances.",
		),
		'slide_03' => array(

			'heading'    => __( 'Meet the JPP Consulting Team', 'kenda-custom' ),

			'subheading' => __( 'Enterprise-grade marketing technology, human oversight, and disciplined messaging', 'kenda-custom' ),

			'stat'       => __( "100+ Years' Combined Experience", 'kenda-custom' ),

			'tags'       => __( 'Digital Marketing • Software Development • Telecommunications • Best-in-Breed IT Products • Human Resource Management', 'kenda-custom' ),

			'cards'      => array(

				array(
					'image' => '',
					'title' => __( 'AI Accountability Audit', 'kenda-custom' ),
					'desc'  => __( 'Enterprise-grade AI ethics and governance assessment', 'kenda-custom' ),
				),

				array(
					'image' => '',
					'title' => __( 'AI Agent', 'kenda-custom' ),
					'desc'  => __( 'AI-powered contact handling with human oversight', 'kenda-custom' ),
				),

				array(
					'image' => '',
					'title' => __( 'Intent Digital Marketing', 'kenda-custom' ),
					'desc'  => __( 'Multichannel campaigns, copywriting for measurable results', 'kenda-custom' ),
				),

				array(
					'image' => '',
					'title' => __( 'AI Data Center Consulting / Backlash-to-Partnership Advisory', 'kenda-custom' ),
					'desc'  => '',
				),

				array(
					'image' => '',
					'title' => __( 'NoW Video', 'kenda-custom' ),
					'desc'  => __( 'Real-Time Voice Translation / Transcription video chat', 'kenda-custom' ),
				),

				array(
					'image' => '',
					'title' => __( 'Ask Carrie', 'kenda-custom' ),
					'desc'  => __( 'AI-knowledge Base', 'kenda-custom' ),
				),

				array(
					'image' => '',
					'title' => __( 'Explainer Videos', 'kenda-custom' ),
					'desc'  => __( 'Animated educational videos', 'kenda-custom' ),
				),

				array(
					'image' => '',
					'title' => __( 'Strategic AI Development', 'kenda-custom' ),
					'desc'  => __( 'End-to-end design / build / host / manage', 'kenda-custom' ),
				),

			),

		),
		'slide_04' => array(
			'heading'      => __( 'Website Revamp', 'kenda-custom' ),
			'arrow_title'  => __( 'Immediate Brand Build', 'kenda-custom' ),
			'lead'         => __( 'As soon as kendatomesmcclain4kc.com is revamped, the brand-building engine starts', 'kenda-custom' ),
			'steps'        => array(
				array(
					'num'   => '1',
					'title' => __( 'Launch the refreshed brand', 'kenda-custom' ),
					'desc'  => __( "Updated design, pillar messaging, and conversion paths.\nCampaign colors, headline hierarchy, calls-to-action, donation/volunteer flows.\nConsistent visual language across web, social, text, and streaming.", 'kenda-custom' ),
				),
				array(
					'num'   => '2',
					'title' => __( 'Install tracking & learn fast', 'kenda-custom' ),
					'desc'  => __( "Website tracking code activated immediately.\nVisitor behavior informs issue messaging and retargeting.\nDashboards monitor clicks, returns, video views, donations, and volunteer intent.", 'kenda-custom' ),
				),
				array(
					'num'   => '3',
					'title' => __( 'Build recognition daily', 'kenda-custom' ),
					'desc'  => __( "Daily posting begins with Kenda's refreshed message and look.\nBrand recall grows by zip code, generation, and issue interest.\nEvery channel reinforces the same Public Safety, Infrastructure, and Economic Opportunity story.", 'kenda-custom' ),
				),
				array(
					'num'   => '4',
					'title' => __( 'Virtual Assistance + Phone', 'kenda-custom' ),
					'desc'  => __( "Set up virtual assistance with a dedicated phone number to handle incoming calls, texts, and scheduling.\nCapture voter questions, meeting requests, volunteer interest, event RSVPs, and donor follow-up needs.\nRoute conversations to the campaign team/CRM so no important contact is missed.", 'kenda-custom' ),
				),
			),
		),
		'slide_05' => array(
			'heading'         => __( 'This Is How You Win', 'kenda-custom' ),
			'subheading'      => __( 'Message discipline + voter data + authentic service', 'kenda-custom' ),
			'bullets'         => "• Position Kenda Tomes McClain as a trusted problem-solver and fiscally serious leader — not politics as usual.\n• Market the candidate with precision, backed by AI, human oversight, and a genuine record of community service.\n• Deliver the right message, to the right generation, in the right zip code — repeated consistently until the primary.\n• Use social, streaming TV, TargetText, web tracking, virtual town halls, and multilingual access to reach every Kansas City community.",
			'formula_label'   => __( 'The winning formula is simple:', 'kenda-custom' ),
			'formula_text'    => __( 'message discipline + voter data + authentic service', 'kenda-custom' ),
			'objective_label' => __( 'Primary Objective', 'kenda-custom' ),
			'objective_text'  => __( 'Advance Kenda through the April 2027 top-two mayoral primary by making fiscal discipline, safer neighborhoods, reliable infrastructure, and shared opportunity the center of the conversation.', 'kenda-custom' ),
		),
		'slide_07' => array(
			'deliverable' => __( 'Deliverable: Greater Kansas City sentiment baseline refreshed continuously through the April 2027 primary.', 'kenda-custom' ),
			'table'       => array(
				array(
					'pillar'  => __( 'Public Safety', 'kenda-custom' ),
					'measure' => __( 'Crime, response times, domestic violence, and neighborhood trust.', 'kenda-custom' ),
					'message' => __( 'Frame Kenda as the disciplined, results-first leader voters can trust to make neighborhoods safer.', 'kenda-custom' ),
				),
				array(
					'pillar'  => __( 'Infrastructure', 'kenda-custom' ),
					'measure' => __( 'Roads, transit, water, and basic-service reliability across KC neighborhoods.', 'kenda-custom' ),
					'message' => __( 'Lead with Kenda’s fix-what’s-broken competence and neighborhood accountability.', 'kenda-custom' ),
				),
				array(
					'pillar'  => __( 'Economic Opportunity', 'kenda-custom' ),
					'measure' => __( 'Jobs, small business, cost of living, and development that benefits residents.', 'kenda-custom' ),
					'message' => __( 'Position Kenda’s finance expertise as the credible path to shared, accountable growth.', 'kenda-custom' ),
				),
			),
		),
		'slide_08' => array(
			'heading'    => __( 'TargetText', 'kenda-custom' ),
			'strategy'   => __( 'Strategy:', 'kenda-custom' ),
			'stat'       => __( 'Up to 250,000 Text Messages', 'kenda-custom' ),
			'lead'       => __( 'Strategically sent based on sentiment data, voter segment, and best time to send', 'kenda-custom' ),
			'taglines'   => array( __( 'Right message.', 'kenda-custom' ), __( 'Right voter.', 'kenda-custom' ), __( 'Right moment.', 'kenda-custom' ) ),
			'includes'   => "• Up to 250,000 text messages during the primary campaign window.\n• Segmented SMS/MMS outreach by zip code, generation, issue interest, and engagement behavior.\n• Message variants aligned to Public Safety, Infrastructure, and Economic Opportunity sentiment.\n• Best send windows determined by response patterns, sentiment signals, and voter behavior.\n• A/B testing identifies strongest hooks, calls-to-action, and follow-up sequences.\n• Texts support donations, volunteers, event turnout, video views, persuasion, and GOTV.",
			'optimized'  => "• Strategic review before major sends.\n• Respectful, compliant outreach with clear sender identity and opt-out handling.\n• Performance feedback loops refine daily social, streaming, and website retargeting.",
			'opt_content' => "• First optional item\n• Second optional item\n• Third optional item",
			'opt_title'  => __( 'How sends are optimized', 'kenda-custom' ),
			'human'      => __( 'Human oversight', 'kenda-custom' ),
		),
		'slide_09' => array(
			'heading'      => __( 'Streaming TV / Connected TV Advertising', 'kenda-custom' ),
			'subheading'   => __( 'Premium inventory, voter-file targeting, and closed-loop attribution', 'kenda-custom' ),
			'logos_label'  => __( 'Available streaming environments include:', 'kenda-custom' ),
			'logos'        => array( 'Hulu', 'Peacock', 'Paramount+', 'ESPN', 'Sling', '500+' ),
			'target_title' => __( 'Precision Targeting', 'kenda-custom' ),
			'target'       => "• Age, income, homeownership, language, party, and interest.\n• Matched to voter-file segments and website engagement.",
			'attrib_title' => __( 'Closed-Loop Attribution', 'kenda-custom' ),
			'attrib'       => "• Track which voters saw ads and then visited the campaign website.\n• Use results to refine social, text, and web messaging.",
			'video_title'  => __( 'AI-Generated Video', 'kenda-custom' ),
			'video'        => "• Rapid production and iteration.\n• Creative updated as sentiment shifts and campaign moments emerge.",
		),
		'slide_10' => array(
			'heading'    => __( 'Winning Strategy & Services', 'kenda-custom' ),
			'subheading' => __( 'The full primary campaign delivery engine', 'kenda-custom' ),
			'services'   => array(
				array( 'num' => '1', 'title' => __( 'Data & AI Sentiment', 'kenda-custom' ), 'desc' => __( 'Zip-code-level analysis, pillar sentiment, opponent-field monitoring, message refinement.', 'kenda-custom' ) ),
				array( 'num' => '2', 'title' => __( 'Website Tracking', 'kenda-custom' ), 'desc' => __( 'Revamped site, tracking code, engagement measurement, retargeting audiences.', 'kenda-custom' ) ),
				array( 'num' => '3', 'title' => __( 'TargetText + Voicemail', 'kenda-custom' ), 'desc' => __( 'Up to 250,000 strategic texts, MMS, segmented follow-ups, ringless voicemail drops.', 'kenda-custom' ) ),
				array( 'num' => '4', 'title' => __( 'Streaming TV / CTV', 'kenda-custom' ), 'desc' => __( 'Premium streaming placements, voter-file targeting, website attribution.', 'kenda-custom' ) ),
				array( 'num' => '5', 'title' => __( 'Daily Social Posting', 'kenda-custom' ), 'desc' => __( 'Facebook, Instagram, TikTok, LinkedIn content aligned to the brand and daily insights.', 'kenda-custom' ) ),
				array( 'num' => '6', 'title' => __( 'Community Access', 'kenda-custom' ), 'desc' => __( 'Virtual town halls, multilingual reach, and ongoing voter engagement across KC communities.', 'kenda-custom' ) ),
			),
		),
		'slide_11' => array(
			'heading'    => __( 'Service Delivery Timeline', 'kenda-custom' ),
			'subheading' => __( 'Week of September 14, 2026 through the April 2027 primary', 'kenda-custom' ),
			'phases'     => array(
				array(
					'num'    => '1',
					'period' => __( 'Week of Sept. 14, 2026', 'kenda-custom' ),
					'title'  => __( 'Launch & Foundation', 'kenda-custom' ),
					'desc'   => __( 'Revamp website; capture Kenda’s voice; install tracking; deliver Greater KC sentiment baseline.', 'kenda-custom' ),
				),
				array(
					'num'    => '2',
					'period' => __( 'Oct.–Dec. 2026', 'kenda-custom' ),
					'title'  => __( 'Message Build', 'kenda-custom' ),
					'desc'   => __( 'Zip-code and generational message sets; brand-building content; continuous sentiment refinement.', 'kenda-custom' ),
				),
				array(
					'num'    => '3',
					'period' => __( 'Jan.–Mar. 2027', 'kenda-custom' ),
					'title'  => __( 'Streaming Air War', 'kenda-custom' ),
					'desc'   => __( 'Launch CTV/streaming ads across premium channels; optimize with closed-loop attribution.', 'kenda-custom' ),
				),
				array(
					'num'    => '4',
					'period' => __( 'Ongoing', 'kenda-custom' ),
					'title'  => __( 'Content Engine', 'kenda-custom' ),
					'desc'   => __( 'Daily social posting; up to 250,000 strategic TargetText messages; ringless voicemail; AI video iteration.', 'kenda-custom' ),
				),
				array(
					'num'    => '5',
					'period' => __( 'Through April 2027 Primary', 'kenda-custom' ),
					'title'  => __( 'GOTV & Rapid Response', 'kenda-custom' ),
					'desc'   => __( 'Dashboards, rapid response, best-time-to-send text pushes, turnout reminders, message optimization.', 'kenda-custom' ),
				),
			),
		),
		'slide_12' => array(
			'heading'    => __( 'Investment & Payment Plan', 'kenda-custom' ),
			'subheading' => __( 'Primary campaign deliverables only', 'kenda-custom' ),
			'payments'   => array(
				array(
					'label'  => __( 'Payment 1 — 50%', 'kenda-custom' ),
					'amount' => '$38,327',
					'note'   => __( 'due upon proposal acceptance.', 'kenda-custom' ),
				),
				array(
					'label'  => __( 'Payment 2 — 50%', 'kenda-custom' ),
					'amount' => '$38,327',
					'note'   => __( 'due upon completion of ads and video commercials.', 'kenda-custom' ),
				),
			),
			'total'       => '$76,654',
			'total_label' => __( 'Total Proposal Cost', 'kenda-custom' ),
			'disclaimer'  => __( 'Payments made payable to JPP Consulting, LLC.', 'kenda-custom' ),
			'quote'       => __( 'Money is a tool for messaging — every dollar goes toward reaching voters where they live, scroll, stream, and gather.', 'kenda-custom' ),
		),
		'slide_13' => array(
			'heading'    => __( 'Why This Wins', 'kenda-custom' ),
			'subheading' => __( 'A disciplined primary campaign built for speed, trust, and measurable voter contact', 'kenda-custom' ),
			'intro'      => __( 'This is the campaign that advances Kenda Tomes McClain through the April 2027 primary and toward the office of Mayor of Kansas City.', 'kenda-custom' ),
			'bullets'    => "• Kenda owns the fiscal-credibility and accountability lane in a city hungry for disciplined leadership.\n• The revamped website becomes the brand hub; brand-building starts immediately after launch across every channel.\n• A sentiment baseline on all three pillars keeps the campaign grounded in what Greater Kansas City actually thinks.\n• Up to 250,000 strategic text messages are sent by segment, sentiment signal, and best time to send.\n• AI-generated commercials keep the campaign fast, responsive, and always on-message.\n• Zip-code-level data plus generational targeting reaches the exact voters who decide a top-two primary.",
		),
		'slide_14' => array(
			'heading'    => __( 'Kenda Tomes McClain 4 KC', 'kenda-custom' ),
			'subheading' => __( 'Leadership for ALL of Kansas City', 'kenda-custom' ),
			'line_1'     => '',
			'line_2'     => '',
			'line_3'     => '',
			'line_4'     => '',
			'line_5'     => '',
			'thank_you'  => __( 'THANK YOU', 'kenda-custom' ),
			'image' => '',
		),
	);
}

/**
 * @return array<string, array<string, mixed>>
 */
function kenda_ppt_slides(): array {
	$stored = get_option( 'kenda_ppt_settings', array() );
	if ( ! is_array( $stored ) ) {
		$stored = array();
	}
	return array_replace_recursive( kenda_ppt_default_slides(), $stored );
}

/**
 * @param mixed $default Default value.
 * @return mixed
 */
function kenda_ppt( string $slide, string $key, $default = '' ) {
	$slides = kenda_ppt_slides();
	return $slides[ $slide ][ $key ] ?? $default;
}

/**
 * @return list<string>
 */
function kenda_ppt_lines( string $text ): array {

    // Convert bullet characters to line breaks.
    $text = preg_replace( '/\s*•\s*/u', "\n", $text ) ?? $text;

    // Split by line breaks.
    $lines = preg_split( '/\r\n|\r|\n/', $text ) ?: array();

    return array_values(
        array_filter(
            array_map(
                static function ( string $line ): string {
                    return trim(
                        preg_replace( '/^[•\-\*]\s*/u', '', $line ) ?? $line
                    );
                },
                $lines
            ),
            static fn ( string $line ): bool => '' !== $line
        )
    );
}

add_action(
	'after_setup_theme',
	function (): void {
		$version = (int) get_option( 'kenda_ppt_settings_version', 0 );
		if ( $version >= 3 ) {
			return;
		}
		$defaults = kenda_ppt_default_slides();
		$stored   = get_option( 'kenda_ppt_settings', array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		$merged = array_replace_recursive( $defaults, $stored );
		if ( $version < 3 ) {
			$merged['slide_14'] = $defaults['slide_14'];
		}
		update_option( 'kenda_ppt_settings', $merged );
		update_option( 'kenda_ppt_settings_seeded', 1 );
		update_option( 'kenda_ppt_settings_version', 3 );
	}
);
