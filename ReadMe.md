Current versions: 
	CKEditor - 4.4.6  http://download.cksource.com/CKEditor/CKEditor/CKEditor%204.4.6/ckeditor_4.4.6_full.zip
	KCFinder - 3.12 https://github.com/sunhater/kcfinder/releases/tag/3.12

put KCFinder folder in WebRoot/vendors or any other folder created at WebRoot except protected.
Create upload folder in WebRoot. Make it writable.


CKEditor in the form's textarea fields (extension EditCK)

Options:

uploadPath  - Path to upload folder from the WebRoot. Default: '/upload'
vendorsPath - Path to folder with KCFinder from the WebRoot. Default: '/vendors'
inline - CKEditor toolbar is always visible (inline: false) or only when the editable field has focus (inline: false). Default:false.
config - array with config options of CKEditor. Options list: http://docs.ckeditor.com/#!/api/CKEDITOR.config

example:

$this->widget('ext.editCK.EditCK',
            array('model'=>$model,'attribute'=>'body',
                'inline'=>true,));

***************************************

CKEditor to edit and save text blocks on the fly (extension InlineCK).

We need to add extra-plugin savebtn to CKEditor. It places the save button in CKEditor's toolbar and make Ajax request that saves data when user press the button.
Plugin origin: http://stackoverflow.com/questions/18956257/how-to-add-an-ajax-save-button-with-loading-gif-to-ckeditor-4-2-1-working-samp

Options:

url - url controller that saves data (data to save are in $_POST['text']).

example:

in the view:

    $this->beginWidget('ext.editCK.InlineCK',
            array('url'=>$this->createUrl('save',array('id'=>$data->id))));

        echo $data->content;

    $this->endWidget();

in the controller:

    public function actionSave($id) {

        $model = $this->loadModel($id);
        $model->content = $_POST['text'];
        $model->save();

    }


See options for EditCK (except inline).



