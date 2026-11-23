<?php
/**
 * U-Teal · German case studies + German theme templates (ONE-TIME snippet)
 * Paste into wp-admin › Snippets › Add New · type PHP · "Only run once" · Save, then click ▶ (run).
 * Needs: case-studies-cpt.php active, Polylang with Deutsch (de), case_study translatable.
 * Safe to run twice: skips cases/templates that already have a German translation. Delete afterwards.
 *
 * 1. Creates the 7 German case studies (title, German slug, excerpt = tile text, content =
 *    Ziele/Vorgehensweise/Ergebnis, ACF fields, case group, order, featured image), sets them to
 *    German and links each one to its English case as the translation.
 * 2. Copies the theme templates "Case study – single" (224) and "404 – page not found" (251)
 *    to German translations ("… – DE"), same layout and conditions. Texts are translated afterwards.
 * Source: client doc 20260915_References_DE.
 */

if ( ! function_exists( 'ut_de_h3' ) ) {
	function ut_de_h3( $t ) {
		return '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . $t . '</h3><!-- /wp:heading -->' . "\n\n";
	}
	function ut_de_p( $t ) {
		return '<!-- wp:paragraph --><p>' . $t . '</p><!-- /wp:paragraph -->' . "\n\n";
	}
	// $items: strings, or array( 'text', array( sub items ) ) for one nested level.
	function ut_de_list( $items, $ordered = false, $class = '' ) {
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
				$out .= '<!-- wp:list-item --><li>' . $item[0] . ut_de_list( $item[1] ) . '</li><!-- /wp:list-item -->';
			} else {
				$out .= '<!-- wp:list-item --><li>' . $item . '</li><!-- /wp:list-item -->';
			}
		}
		return $out . '</' . $tag . '><!-- /wp:list -->' . "\n\n";
	}
}

// 'en' = slug of the English case it translates.
$ut_de_cases = array(

	array(
		'en'      => 'probral',
		'slug'    => 'probral-evaluierung',
		'order'   => 1,
		'group'   => 'higher-education',
		'image'   => 78,
		'title'   => 'Internationale Forschungsförderung weiterentwickeln: Wirkungsanalyse und Programmentwicklung für den DAAD und CAPES',
		'excerpt' => 'PROBRAL fördert seit 1994 gemeinsame Forschungsvorhaben brasilianischer und deutscher Forschungsgruppen und die Mobilität des wissenschaftlichen Nachwuchses. Zum 20-jährigen Bestehen habe ich das Programm im Evaluationsteam von joyn-coop für den DAAD untersucht. Wir haben untersucht, was es erreicht hat, wie gut es zur heutigen Wissenschaftslandschaft Brasiliens passt und wie es sich weiterentwickeln kann.',
		'intro'   => 'PROBRAL ist ein gemeinsames Programm des Deutschen Akademischen Austauschdienstes (DAAD) und der brasilianischen Förderagentur CAPES. Es unterstützt brasilianische und deutsche Forschungsgruppen, die gemeinsam an einem wissenschaftlichen Vorhaben arbeiten. Gefördert wird vor allem die Mobilität von Wissenschaftler:innen, mit dem Ziel, den wissenschaftlichen Nachwuchs weiterzubilden. Zum 20-jährigen Bestehen wollten DAAD und CAPES wissen, was das Programm geleistet hat und wie es künftig aufgestellt sein sollte. Die Evaluierung hat joyn-coop im Auftrag des DAAD durchgeführt. Als Associate von joyn-coop war ich Teil des Evaluationsteams.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele der Evaluierung' ) .
			ut_de_list( array(
				'Das Programm nach Relevanz, Wirksamkeit, Effizienz, Wirkung und Nachhaltigkeit bewerten',
				'Prüfen, wie gut die Maßnahmen zu den Zielen von BMBF, DAAD und CAPES passen',
				'Einschätzen, ob das Programm die Veränderungen in der brasilianischen Wissenschaftslandschaft aufgreift',
				'Gute Praxis und Erfolgsfaktoren herausarbeiten und daraus Vorschläge für die Weiterführung entwickeln',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_list( array(
				'Interviews mit Beteiligten auf allen Ebenen des Programms sowie mit Vertreter:innen von DAAD, CAPES, BMBF und dem Internationalen Büro des BMBF',
				'Analyse der Projektunterlagen',
				'Online-Befragungen der Projektleitungen und der Nachwuchswissenschaftler:innen aus zehn Jahren Programmlaufzeit',
				'Partizipative Gestaltung: Die Beteiligten haben Fragebögen, Interviews und Auswertung in allen Phasen mitgestaltet',
			) ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				array( 'Evaluationsbericht mit guter Praxis, Erfolgsfaktoren und Empfehlungen auf zwei Ebenen:', array(
					'für die Ausschreibung: Bewerbungsverfahren, Ausbau der Zusammenarbeit und gemeinsamer Strukturen, Finanzierung, Datenerhebung',
					'für die Weiterentwicklung von PROBRAL als Programm',
				) ),
				'DAAD und CAPES haben die Empfehlungen umgesetzt.',
			) ),
		'service' => '/de/strategieberatung/',
	),

	array(
		'en'      => 'bifrost',
		'slug'    => 'bifrost-internationalisierung',
		'order'   => 2,
		'group'   => 'higher-education',
		'image'   => 31,
		'title'   => 'Internationalisierung für eine digitale Hochschule neu ausrichten',
		'excerpt' => 'Bifröst University in Island lehrt inzwischen vollständig online, ihre Internationalisierungsstrategie stammte jedoch noch aus der Zeit vor der Umstellung. Ich habe die Hochschulleitung und das International Office dabei begleitet, neue Austauschmodelle für das digitale Lehrformat zu entwickeln und die internationale Partnerschaftsstrategie neu auszurichten.',
		'intro'   => 'Bifröst University hat ihr Lehr- und Lernmodell in den vergangenen Jahren grundlegend verändert und bietet ihre Studiengänge heute vollständig online an. Die internationalen Beziehungen der Hochschule hatten mit diesem Wandel nicht Schritt gehalten: Die bestehende Internationalisierungsstrategie, die Austauschmodelle und ein Teil der Partnerschaften stammten noch aus der Zeit des Präsenzstudiums. Die Hochschulleitung und das International Office suchten Begleitung, um Strategie, Austauschformate und Partnerschaften an das neue, digitale Lehrmodell anzupassen.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele meiner Beratungstätigkeit' ) .
			ut_de_list( array(
				'Internationalisierung für eine digitale Hochschule neu denken',
				'Klarheit über passende Modelle für virtuellen Studierendenaustausch schaffen',
				'Empfehlungen zur Entwicklung der künftigen Partnerschaftsstrategie erarbeiten',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_p( 'Die Begleitung folgte den <a href="/de/#wie-ich-arbeite">drei Schritten, mit denen ich Veränderungsprozesse gestalte</a>:' ) .
			ut_de_list( array(
				'<strong>Hinsehen</strong>: Interviews mit Beteiligten, um die Ausgangslage und unterschiedliche Erwartungen an die Internationalisierung zu verstehen; Workshop mit dem Leitungsteam, in dem wir mit <a href="/de/methoden/#design-thinking">Design Thinking</a> zwei Personas für ausreisende und einreisende Austauschstudierende entwickelt haben',
				'<strong>Ausrichten</strong>: <a href="/de/methoden/#3d-mapping">3D-Mapping</a>, um die gegenwärtige Situation der internationalen Beziehungen sichtbar zu machen und eine Vision der Zukunft zu entwickeln',
				'<strong>Wirksam werden</strong>: Empfehlungen für neue Austauschmodelle und die künftige Partnerschaftsstrategie',
			), true, 'ut-steps-list' ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				'Die Persona-Arbeit machte ein Profil von Studierenden sichtbar, das im bisherigen Blick auf Internationalisierung übersehen worden war, und veränderte damit, wie Bifröst University über ihre künftigen Austauschmodelle nachdenkt.',
				'Einführung neuer Austauschmodelle und Eingehen neuer internationaler Partnerschaften',
			) ),
		'quote'      => 'Nadja combines deep knowledge of international higher education with a clear, participatory process. She listened carefully to our team, made our situation visible and helped us find a direction we could all support.',
		'quote_name' => 'Margrét Jónsdóttir',
		'quote_role' => 'Former Rector, Bifröst University',
		'service'    => '/de/internationalisierung/',
	),

	array(
		'en'      => 'fas',
		'slug'    => 'fas-kooperation',
		'order'   => 3,
		'group'   => 'higher-education',
		'image'   => 29,
		'title'   => 'Internationale Kooperationsarbeit strategisch weiterentwickeln',
		'excerpt' => 'Die Fundació Autònoma Solidària trägt das soziale Engagement der Universitat Autònoma de Barcelona. Als Projektleiterin habe ich gemeinsam mit einer Kollegin eine langjährige Hochschulpartnerschaft der Stiftung evaluiert. Wir haben untersucht, was sie erreicht hat, wie nachhaltig ihre Wirkung ist und was sich auf andere Kooperationen übertragen lässt. Daraus haben wir Empfehlungen für die künftige internationale Kooperationsarbeit der Stiftung abgeleitet.',
		'intro'   => 'Die Fundació Autònoma Solidària (FAS) ist die Stiftung der Universitat Autònoma de Barcelona für soziales Engagement. Ein Schwerpunkt ihrer Arbeit ist Entwicklungszusammenarbeit. Die Stiftung wollte ihre Strategie in diesem Bereich überprüfen. Dafür wählte sie ein konkretes Beispiel: eine Partnerschaft mit einer Universität, die seit über zwanzig Jahren besteht. Aus diesem Fall sollten Erkenntnisse entstehen, die über die einzelne Partnerschaft hinaus gelten. Gemeinsam mit einer Kollegin habe ich diese Partnerschaft evaluiert.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele meiner Beratungstätigkeit' ) .
			ut_de_list( array(
				'Die Partnerschaft nach Relevanz, Wirksamkeit, Effizienz, Wirkung und Nachhaltigkeit bewerten',
				'Die wichtigsten Erfolge und Effekte der Zusammenarbeit herausarbeiten',
				'Erkenntnisse ableiten, die sich auf andere Länder und Partner übertragen lassen',
				'Eine Grundlage für die strategische Reflexion der Stiftung schaffen',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_list( array(
				'Dokumentenanalyse und Vorgespräche mit den Verantwortlichen',
				'Stakeholder-Interviews mit Beteiligten auf allen Ebenen der Zusammenarbeit',
				'Bewertung nach den Kriterien der OECD für Entwicklungszusammenarbeit (DAC)',
				'Gemeinsamer Auswertungsworkshop mit dem Team der Stiftung',
			) ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				'Evaluationsbericht mit Empfehlungen für die künftige Arbeit der Stiftung und Kernempfehlungen für alle künftigen Kooperationen',
				'Die Stiftung hat die Empfehlungen umgesetzt und ihre Zusammenarbeit mit internationalen Partnern darauf aufbauend weiterentwickelt.',
			) ),
		'quote'      => 'Die Evaluierung hat uns ein klares Bild davon gegeben, was unsere Aktivitäten bewirken und worauf wir uns konzentrieren sollten. Auf dieser Grundlage konnten wir die künftige Ausrichtung der internationalen Entwicklungszusammenarbeit unserer Stiftung neu festlegen.',
		'quote_name' => 'Jordi Prat',
		'quote_role' => 'Direktor, Fundació Autònoma Solidària, Universitat Autònoma de Barcelona, Spanien',
		'service'    => '/de/strategieberatung/',
	),

	array(
		'en'      => 'erafrica',
		'slug'    => 'erafrica-evaluierung',
		'order'   => 4,
		'group'   => 'higher-education',
		'image'   => 216,
		'title'   => 'Zusammenarbeit im Konsortium stärken: Empfehlungen für ein europäisch-afrikanisches Fördernetzwerk',
		'excerpt' => 'ERAfrica war ein von der EU gefördertes Netzwerk europäischer und afrikanischer Förderorganisationen. Es sollte eine dauerhafte Forschungszusammenarbeit in Wissenschaft und Technologie aufbauen. Im Evaluationsteam von joyn-coop habe ich eine gemeinsame Ausschreibung des Netzwerks untersucht. Wir haben untersucht, wo Planung, Umsetzung und Finanzierung an Grenzen stießen. Daraus haben wir Empfehlungen für die künftige Zusammenarbeit im Konsortium entwickelt.',
		'intro'   => 'ERAfrica war ein ERA-Net im 7. Forschungsrahmenprogramm der Europäischen Kommission. Ziel war eine langfristige Zusammenarbeit zwischen europäischen und afrikanischen Forschungseinrichtungen in Wissenschaft und Technologie. Dazu gehörten ein gemeinsamer Rahmen für Austausch und Koordination und gemeinsame Förderinstrumente. Mit der ersten gemeinsamen Ausschreibung förderte das Netzwerk im offenen Wettbewerb Forschungsprojekte von Teams aus EU-Mitgliedstaaten und afrikanischen Ländern. Nach dieser ersten Runde wollte das Konsortium wissen, was funktioniert hat und was es für eine zweite Ausschreibung verändern sollte. Die Evaluierung hat joyn-coop im Auftrag des südafrikanischen Ministeriums für Wissenschaft und Technologie durchgeführt. Als Associate von joyn-coop war ich Teil des Evaluationsteams.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele der Evaluierung' ) .
			ut_de_list( array(
				'Die Ausschreibung nach Relevanz, Wirksamkeit, Effizienz, Wirkung und Nachhaltigkeit bewerten',
				'Systematische Herausforderungen in Planung, Start und Umsetzung der Ausschreibung erkennen, einschließlich der Finanzierung',
				'Empfehlungen für eine wirksamere, effizientere und nachhaltigere Fortführung entwickeln',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_list( array(
				'Stakeholder-Interviews mit Beteiligten auf allen Ebenen, darunter die Förderorganisationen aller Partnerländer',
				'Analyse der Programmunterlagen',
				'Drei Online-Befragungen: Antragsteller:innen, externe Gutachter:innen und Mitglieder des Auswahlgremiums',
				'Partizipative Gestaltung: Unterschiedliche Perspektiven flossen in alle Phasen der Datenerhebung und Auswertung ein',
			) ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				'Evaluationsbericht mit zehn konkreten Empfehlungen, die die Grundlage für die Planung weiterer gemeinsamer Ausschreibungen im Konsortium gelegt haben.',
			) ),
		'service' => '/de/strategieberatung/',
	),

	array(
		'en'      => 'norpart',
		'slug'    => 'norpart-gutachten',
		'order'   => 5,
		'group'   => 'higher-education',
		'image'   => 30,
		'title'   => 'Internationale Hochschulpartnerschaften: Expertin für das norwegische Programm NORPART',
		'excerpt' => 'NORPART fördert langfristige akademische Zusammenarbeit und gegenseitige Studierendenmobilität zwischen norwegischen Hochschulen und Partnerinstitutionen im Globalen Süden. Als Mitglied des externen Expert:innenpanels habe ich Anträge auf Förderung von Hochschulpartnerschaften bewertet. Unsere Bewertungen bildeten die Grundlage für die Förderentscheidung.',
		'intro'   => 'Das Norwegian Partnership Programme for Global Academic Cooperation (NORPART) wird von den norwegischen Ministerien für Bildung und Forschung sowie für Auswärtiges finanziert und vom Norwegian Directorate for Higher Education and Skills (HK-dir) verwaltet. Ziel des Programms ist, die Qualität der Hochschulbildung in Norwegen und in ausgewählten Partnerländern durch akademische Zusammenarbeit und gegenseitige Studierendenmobilität zu verbessern. 2024 war ich Mitglied des externen Expert:innenpanels, das die eingereichten Partnerschaftsprojekte bewertet hat.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele meiner Tätigkeit' ) .
			ut_de_list( array(
				'Die Qualität der Anträge unabhängig und nach einheitlichen Kriterien bewerten',
				'Einschätzen, wie gut die geplanten Partnerschaften zu den Programmzielen passen: gestärkte Zusammenarbeit in Lehre und Forschung, Internationalisierung von Studiengängen, gemeinsame Bildungsangebote und Mobilität in beide Richtungen',
				'Eine belastbare Grundlage für die Förderentscheidung schaffen',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_list( array(
				'Einzelbegutachtung der Anträge im Förderportal des Direktorats',
				'Kalibrierungstreffen des Panels, um ein gemeinsames Verständnis der Bewertungskriterien zu sichern',
				'Konsolidierung der Bewertungen im Zweierteam bis zur gemeinsamen Bewertung und Punktzahl',
			) ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				'Konsolidierte Gutachten und Bewertungen als Grundlage für die Förderentscheidung des Direktorats',
			) ),
		'service' => '/de/internationalisierung/',
	),

	array(
		'en'      => 'ukraine-platform',
		'slug'    => 'plattform-wiederaufbau-ukraine',
		'order'   => 6,
		'group'   => 'other-sectors',
		'image'   => 161,
		'title'   => 'Ein Netzwerk aus Wirtschaft, Kommunen, Zivilgesellschaft und Wissenschaft begleiten',
		'excerpt' => 'Organisationsentwicklung für die Plattform Wiederaufbau Ukraine. Die Plattform Wiederaufbau Ukraine vernetzt Unternehmen, Kommunen, Zivilgesellschaft und Wissenschaft für den deutschen Beitrag zum Wiederaufbau der Ukraine. Im Auftrag von GIZ und BMZ habe ich als Senior Beraterin bei joyn-coop das Sekretariat der Plattform über ein Jahr in Organisationsentwicklung und Prozessbegleitung unterstützt.',
		'intro'   => 'Die Plattform Wiederaufbau Ukraine ist eine Initiative der Bundesregierung. Sie soll den deutschen Beitrag zum Wiederaufbau der Ukraine stärken. Dazu bringt sie Unternehmen, Kommunen, zivilgesellschaftliche Organisationen und Wissenschaft zusammen, damit sie sich vernetzen und Expertise austauschen. Das Sekretariat der Plattform suchte Unterstützung, um das Netzwerk weiter auszubauen, die Formate weiterzuentwickeln und als Team gut zusammenzuarbeiten. Von November 2023 bis Dezember 2024 habe ich diesen Prozess im Auftrag von GIZ und BMZ als Senior Beraterin bei joyn-coop begleitet.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele meiner Beratungstätigkeit' ) .
			ut_de_list( array(
				'Das Netzwerk zwischen Wirtschaft, Kommunen, Zivilgesellschaft und Wissenschaft weiter ausbauen und stärken',
				'Formate und Aktivitäten der Plattform weiterentwickeln und eine Vision für ihre Zukunft formulieren',
				'Die Zusammenarbeit im Sekretariat und mit der Projektgruppe im BMZ wirksam gestalten',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_list( array(
				'Die Beratung gemeinsam mit dem Sekretariat partizipativ aufgesetzt',
				'Agile Systeme für Zusammenarbeit und Steuerung auf Distanz eingeführt und Arbeitsprozesse je nach Bedarf mit klassischem oder agilem Projektmanagement begleitet',
				'Reflexions-, Konzeptions- und Strategietreffen konzipiert und moderiert',
				'Netzwerkveranstaltungen, Treffen und Konferenzen mit partizipativen und kreativen Methoden gestaltet, in Präsenz und online, auch mit über 100 Teilnehmenden',
				'Prototyping-Workshops in Präsenz und online durchgeführt',
				'Das Team des Sekretariats und die Projektgruppe im BMZ laufend gecoacht',
			) ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				'Strategische Empfehlungen zur Weiterentwicklung der Formate und eine Entwicklungsvision für die Plattform',
				'Einführen neuer Formate und neuer Formen der Zusammenarbeit',
			) ),
		'service' => '/de/organisationsentwicklung/',
	),

	array(
		'en'      => 'climate-foundation',
		'slug'    => 'klimastiftung',
		'order'   => 7,
		'group'   => 'other-sectors',
		'image'   => 162,
		'title'   => 'Organisationswandel und Führungsentwicklung für eine Klimastiftung',
		'excerpt' => 'Eine europäische Klimastiftung hat sich in einem Zukunftsprozess neu ausgerichtet. Als Senior Beraterin bei joyn-coop habe ich den Prozess begleitet und ein Programm für die Führungsebene entwickelt.',
		'intro'   => 'Eine europäische Stiftung, die sich für Klimaschutz einsetzt und mit Teams in verschiedenen Ländern arbeitet, wollte sich für die kommenden Jahre neu aufstellen. In einem Zukunftsprozess sollten Vision und Werte, Kultur, Prozesse und Entscheidungswege gemeinsam weiterentwickelt werden. Anschließend sollte die Führungsebene das neue Leitbild im Alltag umsetzen. Als Senior Beraterin bei joyn-coop habe ich diesen Prozess 2024 begleitet.',
		'approach' => 'Mein Ansatz',
		'content' =>
			ut_de_h3( 'Ziele meiner Beratungstätigkeit' ) .
			ut_de_list( array(
				'Das Kernteam dabei unterstützen, den Prozess zu gestalten und laufend anzupassen',
				'Vision und Werte, Kultur, Prozesse und Entscheidungswege gemeinsam mit den Mitarbeitenden weiterentwickeln',
				'Strategien für eine nachhaltige Transformation erarbeiten',
				'Die Führungsebene stärken, das neue Leitbild agil umzusetzen',
			) ) .
			ut_de_h3( 'Vorgehensweise' ) .
			ut_de_list( array(
				'Das Kernteam beim Design und bei der Anpassung des Prozesses begleitet',
				'Orientierungs- und Coachingsitzungen mit Gruppen von 15 bis 35 Personen moderiert',
				'Arbeitsgruppen zu Vision und Werten, Kultur, Prozessen, Entscheidungen und Führung gecoacht und trainiert',
				'Ein Programm für die Führungsebene konzipiert',
				'Trainings und Coachings für Führungskräfte zu kompetenzbasierten Entscheidungen, Führungsrollen und Verantwortlichkeiten, Selbstwahrnehmung und Selbstreflexion durchgeführt',
			) ) .
			ut_de_h3( 'Ergebnis' ) .
			ut_de_list( array(
				'Partizipativer Prozess mit aktiver Beteiligung einer Großzahl der Mitarbeitenden der Stiftung',
				'Ein Programm, mit dem die Führungsebene das neue Leitbild umsetzt',
			) ),
		'service' => '/de/fuehrungskraefteentwicklung/',
	),
);

$ut_de_cases_run = function () use ( $ut_de_cases ) {
	if ( ! post_type_exists( 'case_study' ) || ! function_exists( 'pll_set_post_language' ) ) {
		return;
	}

	// 1. German case studies
	foreach ( $ut_de_cases as $c ) {
		$en = get_page_by_path( $c['en'], OBJECT, 'case_study' );
		if ( ! $en ) {
			continue;
		}
		$tr = pll_get_post_translations( $en->ID );
		if ( ! empty( $tr['de'] ) ) {
			continue; // German version already exists
		}
		$id = wp_insert_post( array(
			'post_type'    => 'case_study',
			'post_status'  => 'publish',
			'post_title'   => $c['title'],
			'post_name'    => $c['slug'],
			'post_excerpt' => $c['excerpt'],
			'post_content' => $c['content'],
			'menu_order'   => $c['order'],
			'post_author'  => $en->post_author,
		), true );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		pll_set_post_language( $id, 'de' );
		$tr['en'] = $en->ID;
		$tr['de'] = $id;
		pll_save_post_translations( $tr );

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

	// 2. German copies of theme templates (same layout + conditions; Connect shows them on German pages)
	$templates = array(
		224 => 'Case study – single – DE',
		251 => '404 – page not found – DE',
	);
	$copy_meta = array(
		'_elementor_data',
		'_elementor_edit_mode',
		'_elementor_template_type',
		'_elementor_version',
		'_elementor_pro_version',
		'_elementor_page_settings',
		'_elementor_conditions',
		'_wp_page_template',
	);
	foreach ( $templates as $en_id => $title ) {
		$en = get_post( $en_id );
		if ( ! $en ) {
			continue;
		}
		$tr = pll_get_post_translations( $en_id );
		if ( ! empty( $tr['de'] ) ) {
			continue;
		}
		if ( empty( $tr['en'] ) ) {
			pll_set_post_language( $en_id, 'en' );
		}
		$de_id = wp_insert_post( array(
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
			'post_title'  => $title,
			'post_author' => $en->post_author,
		), true );
		if ( is_wp_error( $de_id ) ) {
			continue;
		}
		foreach ( $copy_meta as $key ) {
			$val = get_post_meta( $en_id, $key, true );
			if ( '' === $val || null === $val ) {
				continue;
			}
			update_post_meta( $de_id, $key, is_string( $val ) ? wp_slash( $val ) : $val );
		}
		$types = wp_get_object_terms( $en_id, 'elementor_library_type', array( 'fields' => 'slugs' ) );
		if ( ! is_wp_error( $types ) && $types ) {
			wp_set_object_terms( $de_id, $types, 'elementor_library_type' );
		}
		pll_set_post_language( $de_id, 'de' );
		$tr['en'] = $en_id;
		$tr['de'] = $de_id;
		pll_save_post_translations( $tr );
	}

	// Refresh Elementor Pro's theme-builder conditions cache
	if ( class_exists( '\ElementorPro\Plugin' ) ) {
		$tb = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'theme-builder' );
		if ( $tb && method_exists( $tb, 'get_conditions_manager' ) ) {
			$tb->get_conditions_manager()->get_cache()->regenerate();
		}
	}
};

if ( did_action( 'wp_loaded' ) ) {
	$ut_de_cases_run();
} else {
	add_action( 'wp_loaded', $ut_de_cases_run, 99 );
}
