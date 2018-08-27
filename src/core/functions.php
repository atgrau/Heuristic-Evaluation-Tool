<?php
  // General Functions

  function getRoleName($id) {
    switch ($id) {
      case 0: return "Evaluator";
      case 1: return "Project Manager";
      case 2: return "Administrator";
    }
  }

  function echoDef($value1, $value2) {
    if (!empty($value1)) {
      echo $value1;
    } else {
      echo $value2;
    }
  }

  function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }

  function infoModal($id, $title, $text) {
    echo '
    <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <strong>'.$title.'</strong>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            '.$text.'
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>';
  }
  ?>
