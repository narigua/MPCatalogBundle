<?php

namespace MP\Bundle\CatalogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class BackendController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}