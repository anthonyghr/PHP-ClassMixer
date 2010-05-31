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
 * Sample4:
 * This fourth example demonstrates a more advanced usage of combinators
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
//   for merging the results of the 'hobby' and 'anti_hobby' methods
//   in the parent classes.
//   In addition, the parent classes to use, and the order in which they
//   should be used is defined
$combinators = array('hobby'      => array('and_concat',
                                           array('ProgrammerMixin', 'BasePerson')),
                     'anti_hobby' => array('and_concat',
                                           array('ProgrammerMixin')));

//Create a mixed 'Person' class where ProgrammerMixin and SkierMixin
//   have been added to BasePerson
ClassMixer::create_mixed_class('Person', 'BasePerson',
                               array('ProgrammerMixin',
                                     'SkierMixin'),
                               $combinators);

//Show resulting functionality. When hobby is called, the 'hobby' methods
//   on ProgrammerMixin and BasePerson are called, in that order (as specified
//   in the array), and the results concatenated.
//   Similarly, when anti_hobby is called, only the method on ProgrammerMixin
//   is called
$p = new Person('Joe', 'Doe');
echo $p->sayName();
echo "\n";
echo $p->hobby();
echo "\n";
echo $p->anti_hobby();
echo "\n";

//---Resulting Output---
//Hi, my name is Joe Doe
//I like to hack and I like to breath
//I don't like bugs