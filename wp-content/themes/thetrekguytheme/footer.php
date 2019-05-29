      <!-- FOOTER -->
      <footer>
        <p class="go-top"><a href="#top" title="Scroll to top"><img src="<?php bloginfo('template_url'); ?>/media/go-top.png"></a></p>
              <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_follow_toolbox"></div>

        
        <p class="footer-text">&copy; <?php echo Date('Y - '); bloginfo('name');?>  &middot;</p>
      </footer>

    </div><!-- /.container -->

<?php 
  wp_footer();
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?php bloginfo('template_url'); ?>/js/jquery.color.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/holder.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/ie10-viewport-bug-workaround.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/script.js"></script>
    <?php if($GLOBALS['page']=="front"):?>
    <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/home.js"></script>
    <?php endif;?>
    <?php if($GLOBALS['page']=="post"):?>
    <script src="<?php bloginfo('template_url'); ?>/js/image-viewer.js"></script>
    <?php endif;?>
    <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59294dadb2e0049d"></script> 
  </body>
</html>