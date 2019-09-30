<?php

namespace application\models;
use application\core\Model;
use application\models\Users\Storage;

class Users extends Model {

    // Storage::getText() shell
    public static function getText() {
        return Storage::getText();
    }

}