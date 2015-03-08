<?php

class ClientController extends Controller {

    //protected $url = "http://utehn.plkhealth.go.th/demo/webapi/index.php/api2/patients/";
    //protected $url = "http://localhost/webapi/index.php/api2/patients/";
    protected  $url = "http://localhost/yii2api/api/web/v1/patients";
    protected $header_auth = array(
        'USERNAME: demo',
        'PASSWORD: demo'
    );

    public function filters() {
        return array();
    }

    public function actionList() {

        $url = $this->url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_auth);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $result = curl_exec($ch);
        curl_close($ch);

        $rawData = json_decode($result, true);
        //print_r($rawData);
        //return;
        $dataProvider = new CArrayDataProvider($rawData, array(
            'keyField' => 'cid',
            'totalItemCount' => count($rawData),
            'sort' => array(
                'attributes' => count($rawData) > 0 ? array_keys($rawData[0]) : ''
            ),
            'pagination' => array(
                'pagesize' => 15
            )
        ));
        $this->render('list', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView($cid = "") {
        $url = $this->url ."/". $cid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_auth);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        $rawData = json_decode($result, true);

        $this->render('view', array(
            'rawData' => $rawData,
            'cid'=>$cid
        ));
    }

    public function actionPost() {

        extract($_POST);
        $url = $this->url;

        $fields = array(
            'name' => urlencode($name),
            'lname' => urlencode($lname),
            'dx' => urlencode($dx),
        );

        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_auth);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        $response = curl_exec($ch);

        curl_close($ch);
        if ($response) {
            $this->redirect(array('list'));
        }
    }

    public function actionPut() {

        extract($_POST);
        $url = $this->url ."/". $cid;

        $put_data = array(
            'name' => $name,
            'lname' => $lname,
            'dx' => $dx
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_auth);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($put_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        if ($response) {
            $this->redirect(array('list'));
        }
    }

    public function actionDelete($cid = NULL) {


        $url = $this->url ."/". $cid;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header_auth);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($response) {
            $this->redirect(array('list'));
            //grid view update by ajax
        }
    }

}
