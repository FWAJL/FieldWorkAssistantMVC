<?php if (!defined('__EXECUTION_ACCESS_RESTRICTION__')) exit('No direct script access allowed'); ?>
<div class="right-aside col-no-right-pad main col-lg-10 col-md-10 col-sm-10">
  <div class="task_list">
    <h3>
      <?php if ($current_task !== NULL) { ?>
        <?php echo $current_task->task_name();
      } else { ?>
        <span class="glyphicon glyphicon-chevron-right"></span>
        <?php
        echo '<span class="noCT">' . $resx["h3_no_task"] . '</span>';
      }
      ?>
    </h3>
    <div class="content-container container-fluid">
      <div class="row col-no-right-margin">
        <div  class="col-lg-5 col-md-5">
          <span class="h4"><?php echo $resx["h3_tasks_active"]; ?></span>
          <?php require $active_list_module; ?>
        </div>
        <?php
        require $tooltip_message_module;
        require $popup_msg_module;
        require $prompt_msg_module;
        ?>
      </div>
    </div>
  </div>
</div><!-- END RIGHT ASIDE MAIN -->