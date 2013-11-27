<?php

class IndexController extends Controller
{
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionError(){
		$this->render('index');
	}
}