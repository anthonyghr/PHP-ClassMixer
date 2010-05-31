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
 * Sample2:
 * This second example demonstrates how the ClassMixer is used to create a mixed
 *    class from a base class
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
 * Mixin class to add additional programmer-like variables and methods to a person
 */
abstract class ProgrammerMixin {
    var $favorite_language;

    function my_language_rules() {
        return "$this->favorite_language rules, all others drool!";
    }
}

//Create a mixed 'Person' class where ProgrammerMixin has been added to BasePerson
ClassMixer::create_mixed_class('Person', 'BasePerson', array('ProgrammerMixin'));

//Show resulting functionality. Variables and methods in the ProgrammerMixin
//   are available the Person class
$p = new Person('Joe', 'Doe');
echo $p->sayName();
echo "\n";
$p->favorite_language = 'C++';
echo $p->my_language_rules();
echo "\n";
$p->favorite_language = 'PHP';
echo $p->my_language_rules();
echo "\n";

//---Resulting Output---
//Hi, my name is Joe Doe
//C++ rules, all others drool!
//PHP rules, all others drool!