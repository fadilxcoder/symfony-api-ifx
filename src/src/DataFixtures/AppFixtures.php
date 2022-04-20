<?php

namespace App\DataFixtures;

use App\Entity\Groups;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const GROUPS = 3;

    private const USERS = 7;

    private const GROUP_REF = 'group_fixtures_';

    private $faker;

    public function __construct() {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadGroups($manager);
        $this->loadUsers($manager);
    }

    private function loadGroups(ObjectManager $manager): void
    {
        for ($i=0; $i<self::GROUPS; $i++):
            $group = new Groups();
            $group->setDetails($this->faker->sentence());
            $this->addReference(self::GROUP_REF . $i, $group);
            $manager->persist($group);
        endfor;

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): void
    {
        for ($i=0; $i<self::USERS; $i++):
            $gid = random_int(0, self::GROUPS - 1);
            $group = $this->getReference(self::GROUP_REF . $gid);
            $user = new Users();
            $user->setName($this->faker->name());
            $user->setGroups($group);
            $manager->persist($user);
        endfor;

        $manager->flush();
    }
}
