<?php // src/Controller/DefaultController.php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Pizza;
use App\Entity\Ingredient;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DataType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\commande;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
 		public function indexAction()
 		{
 		    return [];
 		}


                /**
                * @Route("ajouter_pizza",name="ajouter_pizza")
                */

                public function ajouter_pizza(Request $request)
                {
                $pz =new Pizza();

                $form= $this->createFormBuilder($pz)
                ->add('name',TextType::class)
                ->add('description',TextType::class)
                ->add('price',TextType::class)
                ->add('Register',SubmitType::class,array('label'=>'create pizza'))
                ->getForm();
                

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                $nom = $form['name']->getData();
                $description = $form['description']->getData();
                $prix = $form['price']->getData();
                $pz->setPrice($prix);
                $pz->setName($nom);
                $pz->setDescription($description);

                $em=$this->getDoctrine()->getManager();

                $em->persist($pz);

                $em->flush();
                }


                return $this->render('default/ajouter.html.twig',array('form'=>$form->createView(),
                ));
                }

 		
    	/*public function pizzasAction()
    	{
        return [
    	        'pizzas' => [
    	            '4 fromages', 'Reine', 'Paysanne'
    	        ]
    	    ];
    	}*/

         /**
         * @Route("/pizzas", name="pizzas_list")
         * @Template()
         */
         public function showAction(){
           $em = $this->get('doctrine')->getManager();
           $pizzas = $em->getRepository(Pizza::class)
                ->findAll();
           return $this->render('default/pizzas.html.twig', ['pizzas' => $pizzas]);
            }

        
            

                    /**
                     * @Route("/Ingrediant", name="Ingrediant_list")
                     * @Template()
                     */
                        public function ingredientsAction()
                        {  
                            $em = $this->getDoctrine()->getManager();
                            
                            $ingredients = $em->getRepository(Ingredient::class)
                            ->findAll();
                         
                            return $this->render('default/ingrediant.html.twig', ['ingredients' => $ingredients]);
                            
                        }
        


        /*public function insertPizzasAction() {
        $em = $this->get('doctrine')->getManager();

        $mozarella = new Ingredient;
        $mozarella->setName('Mozarella');
        $parmesan = new Ingredient;
        $parmesan->setName('Parmesan');
        $quatreFromages = new Pizza;
        $quatreFromages
            ->setName('4 fromages')
            ->setPrice(32.2)
            ->setDescription('Pour les fans de fromage')
            ;   
        $quatreFromages->addIngredient($mozarella);
        $quatreFromages->addIngredient($parmesan);
        $em->persist($quatreFromages);
        $em->persist($mozarella);
        $em->persist($parmesan);
        $em->flush();

        return new Response('Pizzas créées');
    }*/

    /**
     * @Route("/listComm", name="listComm")
     * @Template()
     */
    public function commande_list()
    {  
        $em = $this->getDoctrine()->getManager();
        
        $cms = $em->getRepository(commande::class)
        ->findAll();
     
        return $this->render('default/commande.html.twig', ['cms' => $cms]);
        
    }

    /**
     * @Route("commande",name="commande")
     */

    public function ajouter_commande(Request $request)
    {
        $cm =new commande();


        $form= $this->createFormBuilder($cm)
        ->add('adresse',TextType::class)
        ->add('nom',TextType::class)
        ->add('numTel',TextType::class)
        ->add('Register',SubmitType::class,array('label'=>'Ajouter Commande'))
        ->getForm();
       

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
          

           $adresse = $form['adresse']->getData();
           $nom = $form['nom']->getData();
           $numero = $form['numTel']->getData();
          
           $cm->setAdresse($adresse);
           $cm->setNom($nom);
           $cm->setNumTel($numero);

           $em=$this->getDoctrine()->getManager();

           $em->persist($cm);
           $em->flush();
   
   
       }

        return $this->render('default/ajouterCommande.html.twig',array('form'=>$form->createView(),

       ));
    }
}
 ?>