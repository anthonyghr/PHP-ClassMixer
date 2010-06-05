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
 * Sample6:
 * This sixth example demonstrates how we can select which methods
 *    allow 'cutpoints'.
 * Notice that the two cutpoint parameters to the
 *    ClassMixer are now arrays containing the name of methods of the
 *    class(instead of simply 'true'). This parameters tell the ClassMixer
 *    which methods allow 'before' and 'after' cutpoints, respectively.
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
//   to BasePerson. The cutpoint parameters specify that
//   (1) The adieu method (only) accepts before cutpoints.
//   (2) The greet method (only) accepts after cutpoints.
ClassMixer::create_mixed_class('Person', 'BasePerson',
                               array('VerboseGreeterMixin'),
                               $combinators,
                               array('adieu'),
                               array('greet'));

//Show resulting functionality. Notice that 'BEFORE_greet' is not executed
//   as 'greet' does not accept before cutpoints. Similarly for AFTER_adieue.
$p = new Person('Joe', 'Doe');
$p->greet('Jane');
$p->adieu('Jane');

//---Resulting Output---
//Hi, Jane. My name is Joe Doe
//I have greeted Jane
//I am about to bid adieu to Jane
//Good bye, Jane
