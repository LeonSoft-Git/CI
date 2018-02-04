<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\ReporteCType;
use AdminBundle\Form\ReporteEType;
use CoreBundle\Entity\Usuarios;
use PHPExcel;
use PHPExcel_IOFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    /**
     * @Route("/myaccount", name="myaccount")
     * @Method({"GET", "POST"})
     */
    public function myaccountAction(Request $request){
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AdminBundle\Form\MyAccountType', $usuario);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('admin_home');

        }

        return $this->render(':default:myaccount.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/reportes-empresa", name="reportes-empresa")
     */
    public function reporteEAction(Request $request){
        $form = $this->createForm(ReporteEType::class,null,array(
            'method' => 'POST',
            'attr'=>array('id'=>'reporteE-form')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()){
                $data = $form->getData();
                $practicas = array();
                $nombre = $data['empresa']->getNombre();
                $em = $this->getDoctrine()->getManager();
                $grupos = $em->getRepository('CoreBundle:Grupos')->findBy(array('empresas'=>$data['empresa']));
                foreach ($grupos as $grupo):
                    $cursos = $em->getRepository('CoreBundle:Cursos')->findBy(array('grupos'=>$grupo));
                    foreach ($cursos as $curso):
                        $practics = $em->getRepository('CoreBundle:Practicas')->findBy(array('cursos'=>$curso));
                        foreach ($practics as $p):
                            array_push($practicas,$p);
                        endforeach;
                    endforeach;
                endforeach;

                $objPHPExcel = new PHPExcel();

                $objPHPExcel->getProperties()->setCreator("Capacitación Informática")
                    ->setLastModifiedBy("Developer")
                    ->setTitle("Reporte Empresa - ".$nombre)
                    ->setSubject($nombre)
                    ->setDescription("Reporte de Prácticas cargadas en la Empresa ".$nombre.".")
                    ->setKeywords("reporte practicas empresa".$nombre);

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Curso')
                    ->setCellValue('C1', 'Nombre')
                    ->setCellValue('D1', 'Apellido Paterno')
                    ->setCellValue('E1', 'Apellido Materno')
                    ->setCellValue('F1', 'Email')
                    ->setCellValue('G1', 'Fecha y Hora de Carga')
                ;
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

                $i = 2;
                $j = 1;
                foreach ($practicas as $x):
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,$j);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i,$x->getCursos()->getGrupos()->getNombre());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i,$x->getNombre());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i,$x->getApaterno());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i,$x->getAmaterno());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i,$x->getEmail());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i,$x->getCreatedAt());
                    $i = $i + 1;
                    $j = $j + 1;
                endforeach;

                $objPHPExcel->getActiveSheet()->setTitle('Reporte '.$nombre);

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Reporte-'.$nombre.'.xlsx"');
                header('Cache-Control: max-age=0');

                header('Cache-Control: max-age=1');

                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                exit;
            }
        }
        return $this->render(':reportes:empresa.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @Route("/reportes-curso", name="reportes-curso")
     */
    public function reporteCAction(Request $request){
        $form = $this->createForm(ReporteCType::class,null,array(
            'method' => 'POST',
            'attr'=>array('id'=>'reporteC-form')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()){
                $data = $form->getData();
                $practicas = array();
                $nombre = $data['curso'];
                $em = $this->getDoctrine()->getManager();

                $cursos = $em->getRepository('CoreBundle:Cursos')->findBy(array('grupos'=>$nombre->getGrupos(),'fecha'=>$nombre->getFecha()));

                foreach ($cursos as $curso):
                    $practics = $em->getRepository('CoreBundle:Practicas')->findBy(array('cursos'=>$curso));
                    foreach ($practics as $p):
                        array_push($practicas,$p);
                    endforeach;
                endforeach;

                /*$files = array();

                foreach ($practicas as $d) {
                    array_push($files, "../web/uploads/soluciones/".$d->getUrl());
                }

                $zip = new \ZipArchive();
                $zipName = 'Soluciones_'.$nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d').".zip";
                $zip->open($zipName,  \ZipArchive::CREATE);
                foreach ($files as $f) {
                    $zip->addFromString(basename($f),  file_get_contents($f));
                }
                $zip->close();

                $response = new Response(file_get_contents($zipName));
                $response->headers->set('Content-Type', 'application/zip');
                $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
                $response->headers->set('Content-length', filesize($zipName));

                return $response;*/

                $objPHPExcel = new PHPExcel();

                $objPHPExcel->getProperties()->setCreator("Capacitación Informática")
                    ->setLastModifiedBy("Developer")
                    ->setTitle("Reporte Curso - ".$nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d'))
                    ->setSubject($nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d'))
                    ->setDescription("Reporte de Prácticas cargadas en la Empresa ".$nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d').".")
                    ->setKeywords("reporte practicas empresa".$nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d'));

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No.')
                    ->setCellValue('B1', 'Nombre')
                    ->setCellValue('C1', 'Apellido Paterno')
                    ->setCellValue('D1', 'Apellido Materno')
                    ->setCellValue('E1', 'Email')
                    ->setCellValue('F1', 'Fecha y Hora de Carga')
                ;
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

                $i = 2;
                $j = 1;
                foreach ($practicas as $x):
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,$j);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i,$x->getNombre());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i,$x->getApaterno());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i,$x->getAmaterno());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i,$x->getEmail());
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i,$x->getCreatedAt());
                    $i = $i + 1;
                    $j = $j + 1;
                endforeach;

                $objPHPExcel->getActiveSheet()->setTitle('Reporte '.$nombre->getGrupos()->getNombre());

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Reporte-'.$nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d').'.xlsx"');
                header('Cache-Control: max-age=0');

                header('Cache-Control: max-age=1');

                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                exit;
            }
        }
        return $this->render(':reportes:cursos.html.twig',array('form'=>$form->createView()));
    }

    /**
     * @Route("/reportes-curso-zip", name="reportes-curso-zip")
     */
    public function reporteZAction(Request $request){
        $form = $this->createForm(ReporteCType::class,null,array(
            'method' => 'POST',
            'attr'=>array('id'=>'reporteC-form')
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()){
                $data = $form->getData();
                $practicas = array();
                $nombre = $data['curso'];
                $em = $this->getDoctrine()->getManager();

                $cursos = $em->getRepository('CoreBundle:Cursos')->findBy(array('grupos'=>$nombre->getGrupos(),'fecha'=>$nombre->getFecha()));

                foreach ($cursos as $curso):
                    $practics = $em->getRepository('CoreBundle:Practicas')->findBy(array('cursos'=>$curso));
                    foreach ($practics as $p):
                        array_push($practicas,$p);
                    endforeach;
                endforeach;

                if(count($practicas)>0){
                    mkdir('../web/uploads/soluciones/tmp');
                    $files = array();
                    foreach ($practicas as $d) {
                        $file = parse_url($d->getUrl(),PHP_URL_PATH);
                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                        copy("../web/uploads/soluciones/".$d->getUrl(),'../web/uploads/soluciones/tmp/'.$d->getNombre().'-'.$d->getApaterno().'-'.$d->getAmaterno().'.'.$extension);
                        array_push($files, "../web/uploads/soluciones/tmp/".$d->getNombre().'-'.$d->getApaterno().'-'.$d->getAmaterno().'.'.$extension);
                    }

                    $zip = new \ZipArchive();
                    $zipName = 'Soluciones_'.$nombre->getGrupos()->getNombre()."-".$nombre->getFecha()->format('Y-m-d').".zip";
                    $zip->open($zipName,  \ZipArchive::CREATE);
                    foreach ($files as $f) {
                        $zip->addFromString(basename($f),  file_get_contents($f));
                    }
                    $zip->close();

                    $response = new Response(file_get_contents($zipName));
                    $response->headers->set('Content-Type', 'application/zip');
                    $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
                    $response->headers->set('Content-length', filesize($zipName));

                    foreach ($practicas as $d) {
                        $file = parse_url($d->getUrl(),PHP_URL_PATH);
                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                        unlink( "../web/uploads/soluciones/tmp/".$d->getNombre().'-'.$d->getApaterno().'-'.$d->getAmaterno().'.'.$extension);
                    }
                    rmdir($this->getParameter('sol_directory').'/tmp');
                    return $response;
                }else{
                    return $this->render(':reportes:zip.html.twig',array('form'=>$form->createView()));
                }
            }
        }
        return $this->render(':reportes:zip.html.twig',array('form'=>$form->createView()));
    }

    /**
     * Creates a form to delete a Archivos entity.
     *
     * @param Usuarios $usuario The Usuarios entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_account', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Deletes a Usuarios entity.
     *
     * @Route("/{id}", name="delete_account")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuarios $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('security.token_storage')->setToken(null);
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('admin_home');
    }
}
