<?php

/*******************************************************************************
 * PHP ClassMixer Samples
 *
 * Authors:: anthony.gallagher@wellspringworldwide.com
 *
 * Copyright:: Copyright 2009, Wellspring Worldwide, LLC Inc. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Sample1:
 * This first example demonstrates how the ClassMixer can be used to add create
 *    a mixed class that combines a base class (BasePerson) to which a mixin
 *    is added (LawyerMixin). The mixed class Person can call all the methods
 *    of both classes.
 ******************************************************************************/

require_once('../ClassMixer.php');


/**
 * Base class with common person information
 */
abstract class BasePerson {
    private $first_name;
    private $last_name;

    function __construct($fname, $lname) {
        $this->first_name = $fname;
        $this->last_name = $lname;
    }

    function sayName() {
        return "Hi, my name is $this->first_name $this->last_name";
    }
}

/**
 * Mixin class to add additional lawyer-like methods to a person
 */
abstract class LawyerMixin {
    function greet($name) {
        return "I'm going to sue $name!";
    }

    static function kind() {
        return "Lawyer";
    }
}

//Create a mixed 'Person' class where LawyerMixin has been added to BasePerson
ClassMixer::create_mixed_class('Person', 'BasePerson', array('LawyerMixin'));

//Show resulting functionality. Methods in the LawyerMixin are available
//   the Person class
$p = new Person('Joe', 'Doe');
echo $p->sayName();
echo "\n";
echo "I'm a ".Person::kind();
echo "\n";
echo $p->greet('you');
echo "\n";
