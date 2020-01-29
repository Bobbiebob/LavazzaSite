<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 29-1-20
 * Time: 10:25
 */

namespace Application\Controllers;


use Application\Helpers\View;

class ExportController extends BaseController
{

    public function getSelect() {
        return View::get('export.select');
    }

}