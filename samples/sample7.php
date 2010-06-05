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
 * Sample7:
 * This seventh example demonstrates an advanced feature of ClassMixer's combinators
 *    showing how we override the name of the method
 *    in the generated class to be different from the method name of the parent
 *    class.
 * This technique is particularly useful when using mixins to add 'magic' PHP
 *    methods (e.g. __call, __set, __get, etc) which can not be called directly
 *    from the parent class
 * As in sample 4, the combinator information is given as an array. Notice that
 *    the combinator for ___call has a third member.
 *     1) The first member of the array is the combinator function to use.
 *     2) The second member of the array is an array of parent classes.
 *        This array specifies which parent classes to use when generating
 *        the method of the final class, and in what order to call the parent
 *        methods.
 *     3) The third member specifies the name of the method in the generated class
 *        In this example, the generated class will be named __call (the PHP
 *        magic method), which accesses ___call (3 underscores) in the
 *        ExpandableClassMixin class
 * The example also demonstrates the ExpandableClassMixin included with the
 *    ClassMixer library. Adding the ExpandableClassMixin to the list of
 *    parent classes causes the generated class to be 'expandable'.
 *    The 'expandable' class allows you to add mixins dynamically *after* the class
 *       has been defined.
 *    Caveat: The 'dynamic' mixins can only *add* methods to the class.
 *       If the method already exists in the class, the mixin will have no effect
 ******************************************************************************/

require_once('../ClassMixer.php');
require_once('../Mixins.php');

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

//Define that the ClassMixer should generate a method '__call' when it encounters
//   a method '___call' in the parent class
$combinators = array('___call' => array(null, null, '__call'));

//Create a mixed 'Person' class that is expandable
ClassMixer::create_mixed_class('Person', 'BasePerson',
                               array('ExpandableClassMixin'),
                               $combinators);

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

//Now add the ProgrammerMixin to the Person class
ExpandableClass::registerExpander('Person', 'ProgrammerMixin');

//Show resulting functionality. See how calling hobby and anti_hobby on the
//   Person object result in calls to the ProgrammerMixin parent
$p = new Person('Joe', 'Doe');
echo $p->sayName();
echo "\n";
echo $p->hobby();
echo "\n";
echo $p->anti_hobby();
echo "\n";


//---Resulting Output---
//Hi, my name is Joe Doe
//I like to hack
//I don't like bugs