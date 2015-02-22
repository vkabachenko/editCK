#Html-editor extension for Yii 1

##Overview
This extension allows the use of CKEditor in forms and on the fly. You can upload images while editing html.

##Requirements
* This extension was created using Yii 1.1.15. 
* It uses CKEditor 4.4.6 for html editing
* It uses KCFinder 3.12 for uploading images inside editor 

##Main features
* WYSIWYG editor for the textarea with or without the model
* Hide editor toolbar when textarea is not in focus
* Editing html on the fly without a form 
* Upload images and flashes while editing
* Filter disallowed html tags 
* Customize editor toolbar
* Extra plugins to enhance editor functions

##Installation
* Copy the **editCK** folder into **WebRoot/protected/extension** folder
* Download KCFinder from [here](https://github.com/sunhater/kcfinder/releases/tag/3.12)
* Unzip **kcfinder** folder into **WebRoot/vendors** folder
* Create **upload** folder in **WebRoot**. Make it writable.

Last three installation steps are optional if you want to include the upload images feature.

##Usage
###Textarea without model
	$this->widget('ext.editCK.EditCK',
            array('name'=>'editfield',
                  'value'=>'<h2>Test</h2>',
                 ));  
###Textarea with model
	$this->widget('ext.editCK.EditCK',
            array('model'=>$model,
		'attribute'=>'content',
                 ));
###Textarea which hide editor's tooltip when it's not at focus
	$this->widget('ext.editCK.EditCK',
            array('model'=>$model,
		'attribute'=>'content',
		'inline'=>true,
                 ));
###Edit Html on the fly
	$this->beginWidget('ext.editCK.InlineCK',
            array('url'=>$this->createUrl('save',array('id'=>$data->id)),
                	'config'=>array('allowedContent'=>true,),
                 ));
            echo $data->content;
	$this->endWidget();

In that case in the editor's toolbar the Save button appears. Pressing this button leads to Ajax call the action by url option. Changed html data are in the `$_POST['text']`. So the action to save data looks like

	public function actionSave($id) {
		$model = $this->loadModel($id);
		$model->content = $_POST['text'];
		$model->save();
	}

This feature uses `savebtn` plugin described [here](http://stackoverflow.com/questions/18956257/how-to-add-an-ajax-save-button-with-loading-gif-to-ckeditor-4-2-1-working-samp)
###Editor configuration
Use the `config` option. This is array with options described in [CKEditor documentation](http://docs.ckeditor.com/#!/api/CKEDITOR.config).

Examples.

Set editor's height 400px:

	$this->widget('ext.editCK.EditCK',
            array('model'=>$model,
		'attribute'=>'content',
		'config'=>array('height'=>'400',),
                 ));
Allow all html tags in the editor:

	$this->widget('ext.editCK.EditCK',
            array('model'=>$model,
		'attribute'=>'content',
		'config'=>array('allowedContent'=>true,),
                 ));
###Customizing toolbar
You can customize toolbar items by editing the `config.js` file in **ckeditor** folder. This file is empty by default that means the full toolbar. If you will edit toolbar items don't remove the `custom` section that contains the Save button for inline mode.
###Extra plugins
As an example the extension contains the `abbr` plugin that can create abbreviations by selecting certain part of text, edit and delete abbreviations. You can add plugin to editor by configuring the widget:

	$this->widget('ext.editCK.EditCK',
            array('model'=>$model,
		'attribute'=>'content',
		'config'=>array('extraPlugins'=>'abbr',),
                 ));
Please see the plugin basics in the [CKEditor documentation](http://docs.ckeditor.com/#!/guide/plugin_sdk_intro)
