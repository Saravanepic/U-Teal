<?php
/**
 * U-Teal · Case studies SEED (ONE-TIME snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Only run once" · Save and execute once.
 * Needs the permanent snippet (case-studies-cpt.php) active first.
 * Creates the 7 cases (title, slug, excerpt = tile text, content = Goals/Method/Result,
 * ACF fields, case group, order, featured image). Skips any case whose slug already exists,
 * so running it twice does not duplicate anything. Delete the snippet afterwards.
 * Source: client doc 20261103_Case_Studies_EN. External links are on hold (plain text for now).
 */

if ( ! function_exists( 'ut_seed_h3' ) ) {
	function ut_seed_h3( $t ) {
		return '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . $t . '</h3><!-- /wp:heading -->' . "\n\n";
	}
	function ut_seed_p( $t ) {
		return '<!-- wp:paragraph --><p>' . $t . '</p><!-- /wp:paragraph -->' . "\n\n";
	}
	// $items: strings, or array( 'text', array( sub items ) ) for one nested level.
	function ut_seed_list( $items, $ordered = false, $class = '' ) {
		$attrs = array();
		if ( $ordered ) {
			$attrs['ordered'] = true;
		}
		if ( $class ) {
			$attrs['className'] = $class;
		}
		$tag  = $ordered ? 'ol' : 'ul';
		$json = $attrs ? ' ' . wp_json_encode( $attrs ) : '';
		$out  = '<!-- wp:list' . $json . ' --><' . $tag . ' class="wp-block-list' . ( $class ? ' ' . $class : '' ) . '">';
		foreach ( $items as $item ) {
			if ( is_array( $item ) ) {
				$out .= '<!-- wp:list-item --><li>' . $item[0] . ut_seed_list( $item[1] ) . '</li><!-- /wp:list-item -->';
			} else {
				$out .= '<!-- wp:list-item --><li>' . $item . '</li><!-- /wp:list-item -->';
			}
		}
		return $out . '</' . $tag . '><!-- /wp:list -->' . "\n\n";
	}
}

$ut_cases = array(

	array(
		'slug'    => 'bifrost',
		'order'   => 1,
		'group'   => 'higher-education',
		'image'   => 31,
		'title'   => 'Rethinking internationalisation for a digital university',
		'excerpt' => 'Bifröst University in Iceland had moved to fully online teaching, but its internationalisation strategy still dated from before the switch. I helped the university’s leadership and international office develop new exchange models for digital learning and reorient its international partnerships. The university has since put both into practice.',
		'intro'   => 'Bifröst University had fundamentally changed its teaching and learning model and moved all its degree programmes online. Its international relations had not kept pace with this change: the internationalisation strategy, the exchange models and some of the partnerships still dated from its campus-based days. The university’s leadership and international office wanted support to adapt strategy, exchange formats and partnerships to the new digital learning model.',
		'approach' => 'My approach',
		'content' =>
			ut_seed_h3( 'Goals of my consulting work' ) .
			ut_seed_list( array(
				'Rethink internationalisation for a digital university',
				'Clarify which models of virtual student exchange would work',
				'Develop recommendations for the future partnership strategy',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_p( 'The work followed <a href="/#how-i-work">the three steps I use to shape change processes</a>:' ) .
			ut_seed_list( array(
				'<strong>Notice</strong>: interviews with those involved to understand the starting point and the differing expectations of internationalisation; a workshop with the leadership team in which we used <a href="/methods/#design-thinking">design thinking</a> to develop two personas, one for outgoing and one for incoming exchange students',
				'<strong>Align</strong>: <a href="/methods/#3d-mapping">3D mapping</a> to make the current state of international relations visible and develop a vision for the future',
				'<strong>Act with impact</strong>: recommendations for new exchange models and the future partnership strategy',
			), true, 'ut-steps-list' ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				'The persona work brought to light a student profile that the university’s previous approach had overlooked, and it changed how Bifröst University thinks about its future exchange models.',
				'Bifröst University has introduced new exchange models and established new international partnerships.',
			) ),
		'quote'      => 'Nadja combines deep knowledge of international higher education with a clear, participatory process. She listened carefully to our team, made our situation visible and helped us find a direction we could all support.',
		'quote_name' => 'Margrét Jónsdóttir',
		'quote_role' => 'Former Rector, Bifröst University, Iceland',
		'service'    => '/internationalisation/',
	),

	array(
		'slug'    => 'fas',
		'order'   => 2,
		'group'   => 'higher-education',
		'image'   => 29,
		'title'   => 'Strengthening international cooperation strategically',
		'excerpt' => 'The Fundació Autònoma Solidària is the Universitat Autònoma de Barcelona’s foundation for social engagement and development cooperation. As project lead, I evaluated one of the foundation’s long-standing university partnerships together with a colleague. We examined what it had achieved, how lasting its impact had been and what could be transferred to other partnerships. The foundation has since used our recommendations to reorient its approach to international cooperation.',
		'intro'   => 'The Fundació Autònoma Solidària (FAS) is the Universitat Autònoma de Barcelona’s foundation for social engagement. Development cooperation is one of its main areas of work, and the foundation wanted to review its strategy in this area. To do so, it chose a concrete example: a partnership with a university that had been running for more than twenty years. The aim was to gain insights that would apply beyond this single partnership. As project lead, I carried out the evaluation together with a colleague.',
		'approach' => 'Our approach',
		'content' =>
			ut_seed_h3( 'Goals of the evaluation' ) .
			ut_seed_list( array(
				'Assess the partnership against the OECD DAC criteria: relevance, effectiveness, efficiency, impact and sustainability',
				'Identify the main achievements and effects of the collaboration',
				'Draw lessons that can be transferred to other countries and partners',
				'Provide a basis for the foundation’s strategic reflection',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_list( array(
				'Document analysis and initial conversations with the people responsible',
				'Stakeholder interviews with people at all levels of the collaboration',
				'A joint analysis workshop with the foundation’s team',
			) ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				'An evaluation report with recommendations for the foundation’s future work, including core recommendations for all future partnerships',
				'The foundation has since implemented the recommendations and used them to strengthen its work with international partners.',
			) ),
		'quote'      => 'Nadja’s evaluation gave us a clear picture of what our activities achieve and where we need to focus. On this basis, we could reorient the future direction of the Foundation’s international development cooperation work.',
		'quote_name' => 'Jordi Prat',
		'quote_role' => 'Director, Fundació Autònoma Solidària, Universitat Autònoma de Barcelona, Spain',
		'service'    => '/strategy-consulting/',
	),

	array(
		'slug'    => 'probral',
		'order'   => 3,
		'group'   => 'higher-education',
		'image'   => 78,
		'title'   => 'Shaping the future of international research funding: programme evaluation for the DAAD',
		'excerpt' => 'Since 1994, PROBRAL has funded joint research projects between German and Brazilian research groups and the mobility of early-career researchers. For the programme’s 20th anniversary, I was part of joyn-coop’s evaluation team for the DAAD, working as an associate. The DAAD and Brazil’s CAPES have since implemented our recommendations for the programme’s future.',
		'intro'   => 'PROBRAL is a joint programme of the German Academic Exchange Service (DAAD) and the Brazilian funding agency CAPES. It supports German and Brazilian research groups carrying out joint research projects. Funding mainly covers researcher mobility, with a focus on training early-career researchers. For the programme’s 20th anniversary, the DAAD and CAPES wanted to know what it had achieved and how it should evolve. joyn-coop carried out the evaluation on behalf of the DAAD, with me as an associate on the evaluation team.',
		'approach' => 'Our approach',
		'content' =>
			ut_seed_h3( 'Goals of the evaluation' ) .
			ut_seed_list( array(
				'Assess the programme against the OECD DAC criteria: relevance, effectiveness, efficiency, impact and sustainability',
				'Examine how well its activities align with the goals of the then German Federal Ministry of Education and Research (BMBF), the DAAD and CAPES',
				'Assess whether the programme responds to changes in Brazil’s research system',
				'Identify good practice and success factors, and develop recommendations for the programme’s future',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_list( array(
				'Interviews with people at all levels of the programme and with representatives of the DAAD, CAPES, the BMBF and the International Bureau of the BMBF',
				'Analysis of project documents',
				'Online surveys of project leaders and early-career researchers covering ten years of the programme',
				'Participatory design: stakeholders helped shape the questionnaires, interviews and analysis at every stage',
			) ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				array( 'An evaluation report with good practice, success factors and recommendations on two levels:', array(
					'for the funding call: application procedure, strengthening collaboration and joint structures, funding, data collection',
					'for the further development of PROBRAL as a programme',
				) ),
				'The DAAD and CAPES have since implemented the recommendations.',
			) ),
		'service' => '/strategy-consulting/',
	),

	array(
		'slug'    => 'erafrica',
		'order'   => 4,
		'group'   => 'higher-education',
		'image'   => 216,
		'title'   => 'Strengthening collaboration within a consortium: recommendations for a European-African funding network',
		'excerpt' => 'ERAfrica was an EU-funded network of European and African funding organisations that aimed to build lasting research cooperation in science and technology. I was part of joyn-coop’s evaluation team for one of the network’s joint calls, working as an associate. We looked at where planning, implementation and funding ran into difficulties and developed recommendations that laid the groundwork for the consortium’s further joint calls.',
		'intro'   => 'ERAfrica was an ERA-NET funded under the EU’s Seventh Framework Programme (FP7), with the European Commission as funder. It aimed to build long-term cooperation between European and African research institutions in science and technology, through a shared framework for exchange and coordination and joint funding instruments. With its first joint call, the network funded research projects by teams from European and African countries in open competition. After this first round, the consortium wanted to know what had worked and what it should change for a second call. joyn-coop carried out the evaluation on behalf of the then South African Department of Science and Technology, with me as an associate on the evaluation team.',
		'approach' => 'Our approach',
		'content' =>
			ut_seed_h3( 'Goals of the evaluation' ) .
			ut_seed_list( array(
				'Assess the call against the OECD DAC criteria: relevance, effectiveness, efficiency, impact and sustainability',
				'Identify systemic challenges in planning, launching and implementing the call, including funding',
				'Develop recommendations for making future calls more effective, efficient and sustainable',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_list( array(
				'Stakeholder interviews with people at all levels, including the funding organisations of all partner countries',
				'Analysis of programme documents',
				'Three online surveys of applicants, external reviewers and selection panel members',
				'Participatory design: different perspectives fed into every stage of data collection and analysis',
			) ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				'An evaluation report with ten concrete recommendations that laid the groundwork for planning further joint calls within the consortium',
			) ),
		'service' => '/strategy-consulting/',
	),

	array(
		'slug'    => 'norpart',
		'order'   => 5,
		'group'   => 'higher-education',
		'image'   => 30,
		'title'   => 'International university partnerships: expert reviewer for Norway’s NORPART programme',
		'excerpt' => 'NORPART funds long-term academic cooperation and mutual student mobility between Norwegian universities and partner institutions in the Global South. As a member of the external expert panel, I assessed funding applications from university partnerships. Our assessments formed the basis for the funding decisions.',
		'intro'   => 'The Norwegian Partnership Programme for Global Academic Cooperation (NORPART) is funded by the Norwegian Ministry of Education and Research and the Ministry of Foreign Affairs and managed by the Norwegian Directorate for Higher Education and Skills (HK-dir). The programme aims to improve the quality of higher education in Norway and in selected partner countries through academic cooperation and mutual student mobility. In 2024, I was a member of the external expert panel that assessed the submitted partnership proposals.',
		'approach' => 'My approach',
		'content' =>
			ut_seed_h3( 'Goals of my work' ) .
			ut_seed_list( array(
				'Assess the quality of the applications independently and against consistent criteria',
				'Evaluate how well the planned partnerships fit the programme goals: stronger cooperation in teaching and research, internationalisation of degree programmes, joint study programmes and mobility in both directions',
				'Provide a sound basis for the funding decisions',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_list( array(
				'Individual review of the applications in the directorate’s funding portal',
				'Panel calibration meetings to ensure a shared understanding of the assessment criteria',
				'Pairwise consolidation of individual reviews into a joint assessment and score',
			) ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				'Consolidated assessments and scores that formed the basis for the directorate’s funding decisions',
			) ),
		'service' => '/internationalisation/',
	),

	array(
		'slug'    => 'ukraine-platform',
		'order'   => 6,
		'group'   => 'other-sectors',
		'image'   => 161,
		'title'   => 'Supporting a cross-sector network for Ukraine’s reconstruction',
		'excerpt' => 'The German Platform for the Reconstruction of Ukraine, an initiative of the German Federal Government, brings together companies, municipalities, civil society and academia to strengthen Germany’s contribution to rebuilding Ukraine. As a senior consultant at joyn-coop, I supported the platform’s secretariat with organisational development and process facilitation for over a year, on behalf of GIZ and the BMZ. This included agile ways of working for the distributed team, participatory network events, prototyping workshops and coaching. The platform has since introduced new formats and new ways of working together.',
		'intro'   => 'The Platform for the Reconstruction of Ukraine (Plattform Wiederaufbau Ukraine) is an initiative of the German Federal Government. It aims to strengthen Germany’s contribution to the reconstruction of Ukraine. To do so, it brings together academia, companies, municipalities and civil society organisations so that they can network and share expertise. The platform’s secretariat was looking for support in expanding the network, developing its formats further and working well together as a team. From November 2023 to December 2024, I supported this process as a senior consultant at joyn-coop, on behalf of GIZ, the German development agency, and BMZ, Germany’s Federal Ministry for Economic Cooperation and Development.',
		'approach' => 'Our approach',
		'content' =>
			ut_seed_h3( 'Goals of my consulting work' ) .
			ut_seed_list( array(
				'Expand and strengthen the network between academia, business, municipalities and civil society',
				'Evolve the platform’s formats and activities and articulate a vision for its future',
				'Strengthen collaboration within the secretariat and with the project group at the BMZ',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_list( array(
				'Participatory design of the consulting process together with the secretariat',
				'Agile systems for remote collaboration and coordination, with traditional or agile project management as needed',
				'Design and facilitation of reflection, concept and strategy meetings',
				'Design and moderation of network events, meetings and conferences with participatory and creative methods, in person and online, some with more than 100 participants',
				'Prototyping workshops in person and online',
				'Ongoing coaching for the secretariat team and the project group at the BMZ',
			) ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				'Strategic recommendations for evolving the formats and a vision for the platform’s future',
				'The platform introduced new formats and new forms of collaboration.',
			) ),
		'service' => '/organisational-development/',
	),

	array(
		'slug'    => 'climate-foundation',
		'order'   => 7,
		'group'   => 'other-sectors',
		'image'   => 162,
		'title'   => 'Organisational change and leadership development for a European climate foundation',
		'excerpt' => 'A European climate foundation with teams in several countries set out to prepare itself for the years ahead in a “Fit for Future” process. As a senior consultant at joyn-coop, I supported the organisational development process, in which the foundation evolved its vision and values, culture, processes and decision-making together with its staff. I also developed a leadership programme to help its leaders put the new mission statement into practice. A large majority of the foundation’s staff took an active part in the process.',
		'intro'   => 'A European foundation working on climate protection, with teams in several countries, wanted to prepare itself for the years ahead. In a “Fit for Future” process, it set out to evolve its vision and values, culture, processes and decision-making together with its staff. Its leaders would then put the new mission statement into practice in their day-to-day work. As a senior consultant at joyn-coop, I supported this process in 2024.',
		'approach' => 'Our approach',
		'content' =>
			ut_seed_h3( 'Goals of my consulting work' ) .
			ut_seed_list( array(
				'Enable the foundation’s core team to steer the process and adapt it along the way',
				'Evolve vision and values, culture, processes and decision-making together with staff',
				'Develop strategies for lasting change',
				'Help leaders put the new mission statement into practice with agility',
			) ) .
			ut_seed_h3( 'Method' ) .
			ut_seed_list( array(
				'Support for the foundation’s core team in designing and adapting the process',
				'Orientation and coaching sessions with groups of 15 to 35 people',
				'Coaching and training for working groups on vision and values, culture, processes, decision-making and leadership',
				'Design of a programme for the leadership team',
				'Training and coaching for leaders on competence-based decision-making, leadership roles and responsibilities, self-awareness and self-reflection',
			) ) .
			ut_seed_h3( 'Result' ) .
			ut_seed_list( array(
				'A participatory process in which a large majority of the foundation’s staff took an active part',
				'A leadership programme that helps leaders put the new mission statement into practice',
			) ),
		'service' => '/leadership-development/',
	),
);

$ut_seed_run = function () use ( $ut_cases ) {
	if ( ! post_type_exists( 'case_study' ) ) {
		return; // permanent snippet not active
	}
	foreach ( $ut_cases as $c ) {
		if ( get_page_by_path( $c['slug'], OBJECT, 'case_study' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'case_study',
			'post_status'  => 'publish',
			'post_title'   => $c['title'],
			'post_name'    => $c['slug'],
			'post_excerpt' => $c['excerpt'],
			'post_content' => $c['content'],
			'menu_order'   => $c['order'],
		), true );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		set_post_thumbnail( $id, $c['image'] );
		wp_set_object_terms( $id, $c['group'], 'case_group' );
		$meta = array(
			'cs_intro'            => $c['intro'],
			'cs_approach_heading' => $c['approach'],
			'cs_quote'            => isset( $c['quote'] ) ? $c['quote'] : '',
			'cs_quote_name'       => isset( $c['quote_name'] ) ? $c['quote_name'] : '',
			'cs_quote_role'       => isset( $c['quote_role'] ) ? $c['quote_role'] : '',
			'cs_service_link'     => $c['service'],
		);
		foreach ( $meta as $key => $value ) {
			if ( function_exists( 'update_field' ) ) {
				update_field( 'field_' . $key, $value, $id );
			} else {
				update_post_meta( $id, $key, $value );
			}
		}
	}
};

if ( did_action( 'init' ) ) {
	$ut_seed_run();
} else {
	add_action( 'init', $ut_seed_run, 99 );
}
