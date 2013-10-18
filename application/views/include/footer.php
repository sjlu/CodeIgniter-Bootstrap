
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.3.1/lodash.min.js"></script>
   <?php foreach ($js as $script): ?>
   <script src="<?php echo base_url( $script ) ?>"></script>
   <?php endforeach; ?>

</body>
</html>
