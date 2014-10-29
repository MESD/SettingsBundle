Mesd\SettingsBundle\Model\Setting
---------------

    Setting.

    


**Class name**: Setting

**Namespace**: Mesd\SettingsBundle\Model









Properties
----------


**$name** - The setting name



    private string $name






**$value** - The setting value



    private mixed $value






**$settingNode** - SettingNode from the SettingDefinition



    private \Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode






**$cluster** - Cluster Entity



    private \Mesd\SettingsBundle\Entity\Cluster $cluster






Methods
-------


public **isSettingNodeLoaded** (  )


    Is SettingNode loaded

Determine if the SettingNode has been loaded.

The SettingManager loadSetting() method has an optional fourth parameter
which can be set to true if you would like the SettingNode definition to
be loaded when the setting is retrieved. This requires loading, parsing,
and validating the SettingDefinition Yaml file, which will take a little
extra time. Since the SettingNode definition data is not commonly needed
when retrieving settings and their values, the default behavior is to
not loaded the SettingNode.





This method is defined by Setting



--


public **getName** (  )


    Get Setting Name







This method is defined by Setting



--


public **setName** ( string $name )


    Set Setting Name







This method is defined by Setting


    **Arguments**:

    **$name** string  - &lt;p&gt;Setting Name&lt;/p&gt;


--


public **getValue** (  )


    Get Setting Value







This method is defined by Setting



--


public **setValue** ( mixed $value )


    Set Setting Value







This method is defined by Setting


    **Arguments**:

    **$value** mixed  - &lt;p&gt;Setting Value&lt;/p&gt;


--


public **getCluster** (  )


    Get cluster







This method is defined by Setting



--


public **setCluster** ( \Mesd\SettingsBundle\Entity\Cluster $cluster )


    Set cluster







This method is defined by Setting


    **Arguments**:

    **$cluster** \Mesd\SettingsBundle\Entity\Cluster 


--


public **getSettingNode** (  )


    Get SettingNode definition

Get the SettingNode definition, if it has been loaded. See
isSettingNodeLoaded() for more details.





This method is defined by Setting



--


public **setSettingNode** ( \Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode )


    Set SettingNode definition







This method is defined by Setting


    **Arguments**:

    **$settingNode** \Mesd\SettingsBundle\Model\Definition\SettingNode 


--

