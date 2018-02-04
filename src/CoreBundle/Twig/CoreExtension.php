<?php

namespace CoreBundle\Twig;

class CoreExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'core_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sino', array($this, 'sinoFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('tipo', array($this, 'tipoFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('tipoArc', array($this, 'tipoArchivoFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('categoria', array($this, 'categoriaFilter'), array('is_safe' => array('html'))),
        );
    }

    public function sinoFilter($value)
    {
        $result='';
        if($value){
            $result='<i class="fa fa-check-circle" style="color: green;" ></i>';
        }else{
            $result='<i class="fa fa-times-circle" style="color: red;" ></i>';
        }
        return $result;
    }

    public function tipoFilter($value){
        $result='';
        if($value==1){
            $result='SuperUsuario';
        }elseif($value==2){
            $result='Administrador';
        }elseif ($value==3){
            $result='Capacitador';
        }
        return $result;
    }

    public function tipoArchivoFilter($value){
        $result='';
        if($value==1){
            $result='Prácticas';
        }elseif($value==2){
            $result='Manuales';
        }elseif ($value==3){
            $result='Anexos';
        }
        return $result;
    }

    public function categoriaFilter($value){
        $result='';
        if($value==1){
            $result='Excel';
        }elseif($value==2){
            $result='PowerPoint';
        }elseif ($value==3){
            $result='Word';
        }elseif ($value==4){
            $result='Anexos';
        }
        return $result;
    }
}
