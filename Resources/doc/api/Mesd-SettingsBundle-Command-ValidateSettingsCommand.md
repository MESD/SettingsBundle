Mesd\SettingsBundle\Command\ValidateSettingsCommand
===============






* Class name: ValidateSettingsCommand
* Namespace: Mesd\SettingsBundle\Command
* Parent class: Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand







Methods
-------


### configure

    mixed Mesd\SettingsBundle\Command\ValidateSettingsCommand::configure()





* Visibility: **protected**




### execute

    mixed Mesd\SettingsBundle\Command\ValidateSettingsCommand::execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)





* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**



### validateCluster

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Command\ValidateSettingsCommand::validateCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster, \Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition, \Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output, \Symfony\Component\Console\Helper\DialogHelper $dialog, array $confirmation)

Validate a cluster against a setting definition



* Visibility: **protected**


#### Arguments
* $cluster **[Mesd\SettingsBundle\Entity\Cluster](Mesd-SettingsBundle-Entity-Cluster.md)**
* $settingDefinition **[Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md)**
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**
* $dialog **Symfony\Component\Console\Helper\DialogHelper**
* $confirmation **array**


