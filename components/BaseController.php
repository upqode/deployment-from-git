<?php

namespace app\components;

use yii\web\Controller;

class BaseController extends Controller
{
    const LAYOUT_AUTHORIZED = 'authorized';
    const LAYOUT_UNAUTHORIZED = 'unauthorized';
}