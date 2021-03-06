<?php
    require "../inc/initialconfig.php";
    function categoria(){
        switch($_POST["categorias"]){
            case "Procesadores":
                return 3;
                break;
            
            case "Tarjetas Graficas":
                return 2;
                break;
        
            case "Teclados":
                return 4;
                break;
            case "Mouses":
                return 5;
                break;
        }
    }
    function volver($msg){
        header("Location: menuAdmin.php?msg="."$msg");
    }
    $productName=$_POST["nombre"];
    $idCategoria=categoria();
    $descripcionProducto=$_POST["descripcion"];
    if($_FILES['imagen']['name'] != ""){
        $info = new SplFileInfo($_FILES['imagen']['name']);
            $extension = $info->getExtension();
        // Primero, hay que validar que se trata de un PNG
        if (($_FILES["imagen"]["type"] == "image/png")) {
            if($conexionBD->query("INSERT INTO producto (idCateg, nombre, descripcion) VALUES($idCategoria,'$productName','$descripcionProducto');")){
                if($consultaId=$conexionBD->query("SELECT idProd FROM producto ORDER BY idProd DESC LIMIT 1;")){
                    if($arrayId = $consultaId->fetch_assoc()){
                        $idImg =  $arrayId["idProd"];
                    
                    }else{
                        volver("Un error ha ocurrido. Favor de verificar los datos");
                    }
                }else{
                    volver("Un error ha ocurrido. Favor de verificar los datos");
                }
            }else{
                volver("Un error ha ocurrido. Favor de verificar los datos");
            }
         // el archivo es un JPG/GIF/PNG, entonces...
         $info = new SplFileInfo($_FILES['imagen']['name']);
         $extension = $info->getExtension();
         $imagen = $idImg.".".$extension;
         $directorio = "../images/prodPics"; // directorio de tu elección
         // almacenar imagen en el servidor
         move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio.'/'.$imagen);
         $resize = new ResizeImage( $directorio.'/'.$imagen);
         $resize->resizeTo(720, 720, 'exact');
         $resize->saveImage( $directorio.'/'.$imagen);
            volver("Agregado con Exito.");
         exitoAdd();
        }else{
            volver("Un error ha ocurrido. Favor de verificar los datos");
        }
    }else{
        volver("Un error ha ocurrido. Favor de verificar los datos");
    }
           
    class ResizeImage
    {
        private $ext;
        private $image;
        private $newImage;
        private $origWidth;
        private $origHeight;
        private $resizeWidth;
        private $resizeHeight;
        /**
         * Class constructor requires to send through the image filename
         *
         * @param string $filename - Filename of the image you want to resize
         */
        public function __construct( $filename )
        {
            if(file_exists($filename))
            {
                $this->setImage( $filename );
            } else {
                throw new Exception('Image ' . $filename . ' can not be found, try another image.');
            }
        }
        /**
         * Set the image variable by using image create
         *
         * @param string $filename - The image filename
         */
        private function setImage( $filename )
        {
            $size = getimagesize($filename);
            $this->ext = $size['mime'];
            switch($this->ext)
            {
                // Image is a JPG
                case 'image/jpg':
                case 'image/jpeg':
                    // create a jpeg extension
                    $this->image = imagecreatefromjpeg($filename);
                    break;
                // Image is a GIF
                case 'image/gif':
                    $this->image = @imagecreatefromgif($filename);
                    break;
                // Image is a PNG
                case 'image/png':
                    $this->image = @imagecreatefrompng($filename);
                    break;
                // Mime type not found
                default:
                    throw new Exception("File is not an image, please use another file type.", 1);
            }
            $this->origWidth = imagesx($this->image);
            $this->origHeight = imagesy($this->image);
        }
        /**
         * Save the image as the image type the original image was
         *
         * @param  String[type] $savePath     - The path to store the new image
         * @param  string $imageQuality 	  - The qulaity level of image to create
         *
         * @return Saves the image
         */
        public function saveImage($savePath, $imageQuality="100", $download = false)
        {
            switch($this->ext)
            {
                case 'image/jpg':
                case 'image/jpeg':
                    // Check PHP supports this file type
                    if (imagetypes() & IMG_JPG) {
                        imagejpeg($this->newImage, $savePath, $imageQuality);
                    }
                    break;
                case 'image/gif':
                    // Check PHP supports this file type
                    if (imagetypes() & IMG_GIF) {
                        imagegif($this->newImage, $savePath);
                    }
                    break;
                case 'image/png':
                    $invertScaleQuality = 9 - round(($imageQuality/100) * 9);
                    // Check PHP supports this file type
                    if (imagetypes() & IMG_PNG) {
                        imagepng($this->newImage, $savePath, $invertScaleQuality);
                    }
                    break;
            }
            if($download)
            {
                header('Content-Description: File Transfer');
                header("Content-type: application/octet-stream");
                header("Content-disposition: attachment; filename= ".$savePath."");
                readfile($savePath);
            }
            imagedestroy($this->newImage);
        }
        /**
         * Resize the image to these set dimensions
         *
         * @param  int $width        	- Max width of the image
         * @param  int $height       	- Max height of the image
         * @param  string $resizeOption - Scale option for the image
         *
         * @return Save new image
         */
        public function resizeTo( $width, $height, $resizeOption = 'default' )
        {
            switch(strtolower($resizeOption))
            {
                case 'exact':
                    $this->resizeWidth = $width;
                    $this->resizeHeight = $height;
                break;
                case 'maxwidth':
                    $this->resizeWidth  = $width;
                    $this->resizeHeight = $this->resizeHeightByWidth($width);
                break;
                case 'maxheight':
                    $this->resizeWidth  = $this->resizeWidthByHeight($height);
                    $this->resizeHeight = $height;
                break;
                default:
                    if($this->origWidth > $width || $this->origHeight > $height)
                    {
                        if ( $this->origWidth > $this->origHeight ) {
                             $this->resizeHeight = $this->resizeHeightByWidth($width);
                               $this->resizeWidth  = $width;
                        } else if( $this->origWidth < $this->origHeight ) {
                            $this->resizeWidth  = $this->resizeWidthByHeight($height);
                            $this->resizeHeight = $height;
                        }
                    } else {
                        $this->resizeWidth = $width;
                        $this->resizeHeight = $height;
                    }
                break;
            }
            $this->newImage = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);
            imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
        }
        /**
         * Get the resized height from the width keeping the aspect ratio
         *
         * @param  int $width - Max image width
         *
         * @return Height keeping aspect ratio
         */
        private function resizeHeightByWidth($width)
        {
            return floor(($this->origHeight/$this->origWidth)*$width);
        }
        /**
         * Get the resized width from the height keeping the aspect ratio
         *
         * @param  int $height - Max image height
         *
         * @return Width keeping aspect ratio
         */
        private function resizeWidthByHeight($height)
        {
            return floor(($this->origWidth/$this->origHeight)*$height);
        }
    }

?>