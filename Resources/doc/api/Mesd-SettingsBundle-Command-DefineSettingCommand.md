Mesd\SettingsBundle\Command\DefineSettingCommand
===============






* Class name: DefineSettingCommand
* Namespace: Mesd\SettingsBundle\Command
* Parent class: Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand







Methods
-------


### configure

    mixed Mesd\SettingsBundle\Command\DefineSettingCommand::configure()





* Visibility: **protected**




### execute

    mixed Mesd\SettingsBundle\Command\DefineSettingCommand::execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)





* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**



### interact

    mixed Mesd\SettingsBundle\Command\DefineSettingCommand::interact(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)





* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**



### RequestNodeDataArray

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Command\DefineSettingCommand::RequestNodeDataArray(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output, \Symfony\Component\Console\Helper\DialogHelper $dialog)

Request data needed for new Array Setting Node



* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**
* $dialog **Symfony\Component\Console\Helper\DialogHelper**



### RequestNodeDataBoolean

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Command\DefineSettingCommand::RequestNodeDataBoolean(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output, \Symfony\Component\Console\Helper\DialogHelper $dialog, $prototype)

Request data needed for new Boolean Setting Node



* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**
* $dialog **Symfony\Component\Console\Helper\DialogHelper**
* $prototype **mixed**



### RequestNodeDataFloat

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Command\DefineSettingCommand::RequestNodeDataFloat(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output, \Symfony\Component\Console\Helper\DialogHelper $dialog, $prototype)

Request data needed for new Float Setting Node



* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**
* $dialog **Symfony\Component\Console\Helper\DialogHelper**
* $prototype **mixed**



### RequestNodeDataInteger

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Command\DefineSettingCommand::RequestNodeDataInteger(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output, \Symfony\Component\Console\Helper\DialogHelper $dialog, $prototype)

Request data needed for new Integer Setting Node



* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**
* $dialog **Symfony\Component\Console\Helper\DialogHelper**
* $prototype **mixed**



### RequestNodeDataString

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Command\DefineSettingCommand::RequestNodeDataString(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output, \Symfony\Component\Console\Helper\DialogHelper $dialog, $prototype)

Request data needed for new String Setting Node



* Visibility: **protected**


#### Arguments
* $input **Symfony\Component\Console\Input\InputInterface**
* $output **Symfony\Component\Console\Output\OutputInterface**
* $dialog **Symfony\Component\Console\Helper\DialogHelper**
* $prototype **mixed**


