[API Index](ApiIndex.md)


Mesd\SettingsBundle\Entity\Hive
---------------


**Class name**: Hive

**Namespace**: Mesd\SettingsBundle\Entity







    Hive databse entity.

    





Properties
----------


**$id**

Hive ID



    private integer $id






**$name**

Hive name



    private string $name






**$description**

Hive description



    private string $description






**$definedAtHive**

Settings defined at hive



    private boolean $definedAtHive






**$cluster**

Cluster children belonging to hive



    private Collection $cluster






Methods
-------


public **__construct** (  )


Constructor








--

public **getId** (  )


Get id








--

public **setName** ( string $name )


Set name








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $name | string |  |

--

public **getName** (  )


Get name








--

public **setDescription** ( string $description )


Set description








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $description | string |  |

--

public **getDescription** (  )


Get description








--

public **setDefinedAtHive** ( boolean $definedAtHive )


Set definedAtHive








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $definedAtHive | boolean |  |

--

public **getDefinedAtHive** (  )


Get definedAtHive








--

public **addCluster** ( Cluster $cluster )


Add cluster








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $cluster | [Cluster](Mesd-SettingsBundle-Entity-Cluster.md) |  |

--

public **removeCluster** ( Cluster $cluster )


Remove cluster








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $cluster | [Cluster](Mesd-SettingsBundle-Entity-Cluster.md) |  |

--

public **getCluster** (  )


Get cluster








--

[API Index](ApiIndex.md)
