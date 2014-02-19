GameBundle
==========
What is it?

Mastermind is a codebreaking game

You have to guess which colors/numbers are in which place. 
After every move you get feedback. 
White 1 means, that one color/number is right but in the wrong place. 
Black 1 means, that one color/number is right and in right place. 

##Installation

You can install the GameBundle in 3 steps:

- Add following to your composer.json file:
```
    "require": {
        "g11c/gamebundle": "dev-master"
    },
```
Then update composer.

- The next step is to register the Bundle into the AppKernel:
```
    public function registerBundles()
    {
        $bundles = array(
            ...
            new g11c\GameBundle\g11cGameBundle(),
        );
```
- Configure routing.
add following code to app\config\routing.yml:
```
g11c_game:
    resource: "@g11cGameBundle/Resources/config/routing.yml"
    prefix: /

```
Enjoy!