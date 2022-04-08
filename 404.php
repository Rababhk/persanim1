<?php

get_header();
?>

	<div id="primary--" class="content-area--">
		<main id="main" class="site-main">

			<section class="error-404 twp-not-found">
				<div class="twp-wrapper">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'coolte' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'coolte' ); ?></p>

						<?php
						get_search_form();

						?>

					</div><!-- .page-content -->
				</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
