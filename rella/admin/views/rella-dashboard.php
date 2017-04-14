<div class="wrap rella-wrap">

	<div class="rella-dashboard">

		<?php include_once 'rella-registration.php'; ?>

		<?php include_once 'rella-header.php'; ?>

		<div class="tab-content">

			<div id="rella-general" role="tabpanel" class="rella-tab-pane rella-tab-is-active">

				<ul class="rella-cards-container clearfix">

                  <li class="rella-card">
                     <div class="rella-card-inner">
                        <div class="rella-icon-container">
                           <i class="text-gradient fa fa-life-ring"></i>
                        </div>
                        <h3><?php esc_html_e( 'Support Forums', 'boo' ) ?></h3>
                        <div class="rella-status rella-status-is-active">
                           <span><?php esc_html_e( 'Community', 'boo' ) ?></span>
                        </div>
                        <p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adi nunc maximus egestas lectus eu condi. Duis non purus dignissim varius.', 'boo' ) ?></p>
                        <div class="rella-card-footer clearfix">
                           <a class="rella-button" href="#"><span><?php esc_html_e( 'Go to forums', 'boo' ) ?></span> <i class="fa fa-angle-right"></i></a>
                        </div>
                     </div>
                  </li>

                  <li class="rella-card">
                     <div class="rella-card-inner">
                        <div class="rella-icon-container">
                           <i class="text-gradient fa fa-file-text-o"></i>
                        </div>
                        <h3><?php esc_html_e( 'Documentation', 'boo' ) ?></h3>
                        <div class="rella-status rella-status-is-active">
                           <span><?php esc_html_e( 'Knowledge Base', 'boo' ) ?></span>
                        </div>
                        <p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adi nunc maximus egestas lectus eu condi. Duis non purus dignissim varius.', 'boo' ) ?></p>
                        <div class="rella-card-footer clearfix">
                           <a class="rella-button" href="#"><span><?php esc_html_e( 'Read Documentation', 'boo' ) ?></span> <i class="fa fa-angle-right"></i></a>
                        </div>
                     </div>
                  </li>

                  <li class="rella-card">
                     <div class="rella-card-inner">
                        <div class="rella-icon-container">
                           <i class="text-gradient fa fa-video-camera"></i>
                        </div>
                        <h3><?php esc_html_e( 'Video Tutorials', 'boo' ) ?></h3>
                        <div class="rella-status rella-status-is-active">
                           <span><?php esc_html_e( 'Visual Help', 'boo' ) ?></span>
                        </div>
                        <p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adi nunc maximus egestas lectus eu condi. Duis non purus dignissim varius.', 'boo' ) ?></p>
                        <div class="rella-card-footer clearfix">
                           <a class="rella-button" href="#"><span><?php esc_html_e( 'Video tutorial', 'boo' ) ?></span> <i class="fa fa-angle-right"></i></a>
                        </div>
                     </div>
                  </li>

               </ul>

			</div>

			<div id="rella-demos" role="tabpanel" class="rella-tab-pane">
				<?php include_once 'rella-demos.php'; ?>
			</div>

		</div>

	</div>

</div>
