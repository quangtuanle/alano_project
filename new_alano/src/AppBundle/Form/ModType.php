<?php
// src/AppBundle/Form/ModType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ModType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$roles = array(
            'ROLE_ADMIN'    	 => 'Editor',
            'ROLE_SUPER_ADMIN'   => 'Total Editor',
            'ROLE_MEGA_ADMIN' 	 => 'Admin Alano',
        );
		
		$builder
			->add('email', 'email')
			->add('username', 'text')
			->add('plainPassword', 'repeated', array(
				'type' => 'password',
				'first_options' => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password'),
			))
			->add('roles', 'choice', [
				'choices' => $roles,
				'multiple' => false,
				'expanded' => true,
				'label' => 'Choose role:',
				'data' => implode(array_keys($roles))
			])
			->add('termsAccepted', 'checkbox', array(
				'mapped' => false,
				'constraints' => new IsTrue(),
			));		
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User'
		));
	}
	
	public function getName()
	{
		return 'user';
	}
}

?>