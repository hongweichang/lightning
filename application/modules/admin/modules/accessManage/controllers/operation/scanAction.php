<?php
/**
 * @name scanAction.php UTF-8
 * @author ChenJunAn<lancelot1215@gmail.com>
 * 
 * Date 2013-10-9
 * Encoding UTF-8
 */
class scanAction extends CmsAction{
	public function run(){
		$model = $this->app->getAuthManager()->getItemModel(AuthManager::OPERATION);
		
		$click = $this->getQuery('click',null);
		if ( $click !== null ){
			$model->attributes = array(
					'module' => $this->getQuery('module',''),
					'controller' => $this->getQuery('controller'),
					'action' => $this->getQuery('action')
			);
			$formConfig = $this->getController()->getFormConfig($model);
			
			$form = new CForm($formConfig,$model);
			$form->action = $this->createUrl('operation/add');
			$this->setPageTitle('添加操作');
			
			$this->render('add',array('form'=>$form));
			$this->app->end();
		}
		
		$map = $this->loadMap();
		
		$errors = array();
		foreach ( $map as $i => $m ){
			if ( !isset($m['controller'],$m['action']) ){
				unset($map[$i]);
				$errors[] = $i;
				continue;
			}
			if ( !isset($m['module']) ){
				$m['module'] = $map[$i]['module'] = '';
			}
			$module = $m['module'];
			$controller = $m['controller'];
			$action = $m['action'];
			
			$op = $model->findUniqueRecord($module,$controller,$action);
			if ( $op !== null ){
				unset($map[$i]);
			}else {
				$map[$i]['click'] = true;
			}
		}
		
		$this->pageTitle = '扫描操作';
		$this->render('scan',array('map'=>$map));
	}
	
	public function loadMap(){
		$appController = Yii::getPathOfAlias('application.controllers');
		$map = $this->analysis($this->read($appController));
		$modules = $this->app->getModules();
		foreach ( $modules as $name => $config ){
			$class = substr($config['class'],strrpos($config['class'],'.')+1);
			$controllerAlias = substr($config['class'],0,strpos($config['class'],$class)).'controllers';
			
			$path = Yii::getPathOfAlias($controllerAlias);
			$info = $this->read($path);
			if ( $info === array() ){
				continue;
			}
			
			Yii::import($config['class'],true);
			unset($config['class']);
			unset($config['enabled']);
			$module = new $class($name,$this->app,$config);
			$mapTmp = $this->analysis($info,$module);
			$map = array_merge($map,$mapTmp);
		}
		return $map;
	}
	
	public function read($path){
		$resource = opendir($path);
		$info = array();
		while ( ($file=readdir($resource)) !== false ){
			if ( !is_file($path.DS.$file) ){
				continue;
			}
			preg_match('/(.*)Controller/',$file,$matches);
			if ( isset($matches[1]) ){
				$id = lcfirst($matches[1]);
				$info[] = array(
						'id' => $id,
						'file' => $path.DS.$file
				);
			}else {
				continue;
			}
		}
		closedir($resource);
		return $info;
	}
	
	public function analysis($info,$module=null){
		$return = array();
		foreach ( $info as $key => $inf ){
			$id = $inf['id'];
			$file = $inf['file'];
			
			if ( $id === 'service' ){
				continue;
			}
			
			require_once($file);
			$class = ucfirst($id).'Controller';
			$controller = new $class($id,$module);
			if ( ! $controller instanceof SqbController ){
				continue;
			}
			
			$content = file_get_contents($file);
			preg_match_all('/.*public.*function.*action(.*)\(/',$content,$inlineActions);
			if ( isset($inlineActions[1]) ){
				foreach ( $inlineActions[1] as $inlineAction ){
					$return[] = array(
							'module' => $module === null ? '' : $module->getId(),
							'controller' => $id,
							'action' => lcfirst($inlineAction)
					);
				}
			}
			
			$objectActions = $controller->actions();
			foreach ( $objectActions as $name => $action ){
				$return[] = array(
						'module' => $module === null ? '' : $module->getId(),
						'controller' => $id,
						'action' => lcfirst($name)
				);
			}
			
			unset($controller);
		}
		return $return;
	}
}