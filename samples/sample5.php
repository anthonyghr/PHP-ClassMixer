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
 * Sample5:
 * This fifth example demonstrates the use of 'cutpoints'.
 *    Cutpoints resemble the concept of pointcuts in Aspect-Oriented programming,
 *    and define 'points' where it is possible to 'cut' into the
 *    execution of a method, either adding or modifying behavior.
 *    Specifically, ClassMixer allows 'before' and 'after' cutpoints, allowing
 *    the execution the user to alter the behavior of a method before entering
 *    its main body, and/or after leaving its main body.
 * In this example, we show a simple application of cutpoints. Notice the
 *    extra two 'true' parameters passed to the ClassMixer. These parameters
 *    alert the ClassMixer to allow for the execution of cutpoints in the
 *    mixed class.
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

    function greet($name) {
        echo "Hi, $name. My name is $this->first_name $this->last_name\n";
    }
    
    function adieu($name) {
        echo "Good bye, $name\n";
    }
}

/**
 * Mixin class to add additional verbosity to a person's greetings
 */
abstract class VerboseGreeterMixin {
    function BEFORE_greet($name) {
        echo "I am about to greet $name\n";
    }

    function AFTER_greet($name) {
        echo "I have greeted $name\n";
    }

    function BEFORE_adieu($name) {
        echo "I am about to bid adieu to $name\n";
    }

    function AFTER_adieu($name) {
        echo "I have bidded adieu to $name\n";
    }
}

//For this example, the combinators array is empty.
$combinators = array();

//Create a mixed 'Person' class where we have added the VerboseGreeterMixin
//   to BasePerson
ClassMixer::create_mixed_class('Person', 'BasePerson',
                               array('VerboseGreeterMixin'),
                               $combinators,
                               true, true);

//Show resulting functionality. Notice how 'BEFORE_greet' and 'BEFORE_adieue' 
//   are executed prior to the execution of the main body of 'greet' and 'adieu'
//   (respectively). 'AFTER_greet' and 'AFTER_adieue'
//   are executed after the execution of the main body
$p = new Person('Joe', 'Doe');
$p->greet('Jane');
$p->adieu('Jane');

//---Resulting Output---
//I am about to greet Jane
//Hi, Jane. My name is Joe Doe
//I have greeted Jane
//I am about to bid adieu to Jane
//Good bye, Jane
//I have bidded adieu to Jane
