<?php 
include_once("./utils/nodirecto.php");
require_once("./utils/sendgrid/sendgrid-php.php");


class Correo{
    public function __construct($apikey, $emisor){
        $this->sg = new \SendGrid($apikey);
        $this->emisor = $emisor;
    }
    public function registro($receptor, $nombre){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->emisor, "Cafayate Web");
        $email->addTo($receptor);
        $email->setTemplateId("d-0e6c749c979b4598be43e3cfd6c68462");
        $email->addSubstitution("nombre", $nombre);
        try {
            $response = $this->sg->send($email);

        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    public function aprobarSolicitud($receptor, $nombre){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->emisor, "Cafayate Web");
        $email->addTo($receptor);
        $email->setTemplateId("d-5cd37f49daf04007ac5669bead1f6216");
        $email->addSubstitution("nombre", $nombre);
        try {
            $response = $this->sg->send($email);
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    public function rechazarSolicitud($receptor, $nombre, $razon){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->emisor, "Cafayate Web");
        $email->addTo($receptor);
        $email->setTemplateId("d-87c2608747354478bb5bff0747feeac6");
        $email->addSubstitution("nombre", $nombre);
        $email->addSubstitution("razon", $razon);
        try {
            $response = $this->sg->send($email);
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
$correos = new Correo("", "facugastonbarral@gmail.com");

?>