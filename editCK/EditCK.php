<?php

class EditCK extends CInputWidget {

/*
* properties from  CInputWidget
 *
 */
/* @var string name
 * @var string value
 * @var CModel model
 * @var string attribute
 * @var string[] HtmlOptions
 */
/*
 * own properties
 */
    // upload path from the root of the website. Must be writable for all
    public $uploadPath = '/upload';

    //path to folder where KCfinder folder lies (from the root of the website)
    // don't put it in protected folder!
    public $vendorsPath = '/vendors';

    // user's config values for CKEditor. See http://docs.ckeditor.com/#!/api/CKEDITOR.config
    public $config = array();


    public function init() {

        // integration with KCFinder

        $baseDir = Yii::app()->baseUrl.$this->vendorsPath;

        $this->config['filebrowserBrowseUrl'] = $baseDir.'/kcfinder/browse.php?opener=ckeditor&type=files';
        $this->config['filebrowserImageBrowseUrl'] = $baseDir.'/kcfinder/browse.php?opener=ckeditor&type=images';
        $this->config['filebrowserFlashBrowseUrl'] = $baseDir.'/kcfinder/browse.php?opener=ckeditor&type=flash';
        $this->config['filebrowserUploadUrl'] = $baseDir.'/kcfinder/browse.php?opener=ckeditor&type=files';
        $this->config['filebrowserImageUploadUrl'] = $baseDir.'/kcfinder/browse.php?opener=ckeditor&type=images';
        $this->config['filebrowserFlashUploadUrl'] = $baseDir.'/kcfinder/browse.php?opener=ckeditor&type=flash';

        $_SESSION['KCFINDER'] = array(
            'disabled' => false,
            'uploadURL' => Yii::app()->baseUrl.$this->uploadPath,
            'uploadDir' => realpath(Yii::app()->basePath . '/..'.$this->uploadPath),
        );
    }


    public function run() {

        // publish assets
        $excludeFiles = Yii::app() -> assetManager -> excludeFiles;
        array_push($excludeFiles,'LICENSE.md','README.md','CHANGES.md','samples');
        Yii::app() -> assetManager -> excludeFiles = $excludeFiles;

        $baseDir = dirname(__FILE__);
        $assets = CHtml::asset($baseDir.DIRECTORY_SEPARATOR.'ckeditor');

        // register js script file
        Yii::app() -> clientScript -> registerScriptFile($assets.'/ckeditor.js');

        // config array as js object
        $config = CJavaScript::encode($this->config);

        // take name and id from widget
        list($name, $id) = $this->resolveNameID();
        $this->htmlOptions['id'] = $id;

        // register script to replace textarea with ckeditor
        Yii::app() -> clientScript ->
             registerScript('Yii.'.get_class($this).'#'.$id,
            "CKEDITOR.replace('{$name}',{$config});",
             CClientScript::POS_LOAD);

        // make textarea from model or simple form
        if($this->hasModel()) {
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        }
        else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
        }

    } // run

} // class

?>