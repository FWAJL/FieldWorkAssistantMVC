<!--Promt box: genrates a general prompt box-->
<div class="modal fade prompt-modal" tabindex="-1" role="dialog" aria-hidden="true" id="location-prompt">
  <?php
  if (isset($prompt_message) && !empty($prompt_message)) {
    foreach($prompt_message as $the_msg){
      ?>
      <input type="hidden" id="promptmsg-<?php echo $the_msg['promptmsg']['operation'] ?>" value="<?php echo $the_msg['promptmsg']['value'] ?>" />
    <?php
    }
  }

  ?>
  <div class="modal-dialog modal-upload">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="prompt_title"></h4>
      </div>

      <div class="modal-body">
        <input class="form-control" type="text" id="text_input" name="text_input">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary confirmbuttons modal-update" id="prompt_ok">Ok</button>
        <button type="button" class="btn btn-default confirmbuttons" data-dismiss="modal" id="prompt_cancel">Cancel</button>
      </div>

    </div>
  </div>
</div>
<!--Promt box-->