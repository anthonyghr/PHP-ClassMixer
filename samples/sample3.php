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
 * Sample3:
 * This third example demonstrates the use of combinators in the ClassMixer.
 *    Combinators are functions that tell the ClassMiuxer how to
 *    resolve method collisions in the parent classes.
 * Notice how defining a combinator (and_concat) combinator for the hobby method
 *    causes the hobby methods on all the three parent classes to be executed.
 * Notice that when no combinator is defined for the anti_hobby method, ClassMixer
 *    only executes the method of the first parent class that defines it (the parent
 *    BasePerson class in this case)
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

    function hobby() {
        return "I like to breath";
    }

    function anti_hobby() {
        return "I don't like germs";
    }
}

/**
 * Mixin class to add additional programmer-like methods to a person
 */
abstract class ProgrammerMixin {
    function hobby() {
        return "I like to hack";
    }

    function anti_hobby() {
        return "I don't like bugs";
    }
}

/**
 * Mixin class to add additional skier-like methods to a person
 */
abstract class SkierMixin {
    function hobby() {
        return "I like to ski";
    }
}

/**
 * A combinator: This function (which expects string arguments)
 *    concatenates all its arguments.
 * 
 * @return <type>
 */
function and_concat() {
    $args = func_get_args();
    return implode(' and ', $args);
}

//Define that the ClassMixer should use the 'and_concat' combinator
//   for merging the results of the 'hobby' methods in the parent classes
$combinators = array('hobby' => 'and_concat');

//Create a mixed 'Person' class where ProgrammerMixin and SkierMixin
//   have been added to BasePerson
ClassMixer::create_mixed_class('Person', 'BasePerson', 
                               array('ProgrammerMixin',
                                     'SkierMixin'),
                               $combinators);

//Show resulting functionality. When hobby is called, the 'hobby' methods
//   on all 3 parent classes are called, and the results concatenated.
//   The ClassMixer defaults to calling the method in the base class first,
//   followed by the methods in the mixins, in the order they were listed.
$p = new Person('Joe', 'Doe');
echo $p->sayName();
echo "\n";
echo $p->hobby();
echo "\n";
echo $p->anti_hobby();
echo "\n";
