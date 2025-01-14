<?php if (!defined('__EXECUTION_ACCESS_RESTRICTION__')) exit('No direct script access allowed'); ?>
<div class="right-aside col-no-right-pad main col-lg-10 col-md-10 col-sm-10">
  <h3>
    <?php echo $resx["h3_common_field_analytes"] ?>
  </h3>
  <div class="form_sections">
    <div class="content-container container-fluid">
      <div class="row col-no-right-margin">
        <div  class="col-lg-5 col-md-5">
          <!-- field analyte block -->
          <?php require $form_modules[\Applications\PMTool\Resources\Enums\ViewVariables\Analyte::field_analyte_form]; ?>
        </div>
        <div class="col-lg-1 col-md-1">
          <div class="buttons">
            <?php require $form_modules[Applications\PMTool\Resources\Enums\ViewVariables\Analyte::analyte_buttons]; ?>
          </div>
        </div>
        <div  class="col-lg-5 col-md-5 admin-ui">
          <?php
          require $form_modules[\Applications\PMTool\Resources\Enums\ViewVariables\Analyte::common_field_analyte_list];
          require $form_modules[\Applications\PMTool\Resources\Enums\PhpModuleKeys::popup_prompt];
          require $form_modules[\Applications\PMTool\Resources\Enums\PhpModuleKeys::popup_msg];
          ?>
        </div>
      </div>
    </div>
  </div>
</div>