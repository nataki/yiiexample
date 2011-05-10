<?php

class TestController extends CController {
    public function actionIndex() {
        $this->render('index');
    }

    public function actionTest() {
        $this->render('test');
    }

}