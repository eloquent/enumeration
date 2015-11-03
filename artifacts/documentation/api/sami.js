
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">Eloquent</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Eloquent_Enumeration" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Eloquent/Enumeration.html">Enumeration</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Eloquent_Enumeration_Exception" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Eloquent/Enumeration/Exception.html">Exception</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Eloquent_Enumeration_Exception_ExtendsConcreteException" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Enumeration/Exception/ExtendsConcreteException.html">ExtendsConcreteException</a>                    </div>                </li>                            <li data-name="class:Eloquent_Enumeration_Exception_UndefinedMemberExceptionInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html">UndefinedMemberExceptionInterface</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:Eloquent_Enumeration_AbstractEnumeration" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Enumeration/AbstractEnumeration.html">AbstractEnumeration</a>                    </div>                </li>                            <li data-name="class:Eloquent_Enumeration_AbstractMultiton" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Enumeration/AbstractMultiton.html">AbstractMultiton</a>                    </div>                </li>                            <li data-name="class:Eloquent_Enumeration_AbstractValueMultiton" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Enumeration/AbstractValueMultiton.html">AbstractValueMultiton</a>                    </div>                </li>                            <li data-name="class:Eloquent_Enumeration_EnumerationInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Enumeration/EnumerationInterface.html">EnumerationInterface</a>                    </div>                </li>                            <li data-name="class:Eloquent_Enumeration_MultitonInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Enumeration/MultitonInterface.html">MultitonInterface</a>                    </div>                </li>                            <li data-name="class:Eloquent_Enumeration_ValueMultitonInterface" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Eloquent/Enumeration/ValueMultitonInterface.html">ValueMultitonInterface</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Eloquent.html", "name": "Eloquent", "doc": "Namespace Eloquent"},{"type": "Namespace", "link": "Eloquent/Enumeration.html", "name": "Eloquent\\Enumeration", "doc": "Namespace Eloquent\\Enumeration"},{"type": "Namespace", "link": "Eloquent/Enumeration/Exception.html", "name": "Eloquent\\Enumeration\\Exception", "doc": "Namespace Eloquent\\Enumeration\\Exception"},
            {"type": "Interface", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/EnumerationInterface.html", "name": "Eloquent\\Enumeration\\EnumerationInterface", "doc": "&quot;The interface implemented by C++ style enumeration instances.&quot;"},
                    
            {"type": "Interface", "fromName": "Eloquent\\Enumeration\\Exception", "fromLink": "Eloquent/Enumeration/Exception.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "doc": "&quot;The interface implemented by exceptions that are thrown when an undefined\nmember is requested.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "fromLink": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html#method_className", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface::className", "doc": "&quot;Get the class name.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "fromLink": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html#method_property", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface::property", "doc": "&quot;Get the property name.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "fromLink": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html#method_value", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface::value", "doc": "&quot;Get the value of the property used to search for the member.&quot;"},
            
            {"type": "Interface", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/MultitonInterface.html", "name": "Eloquent\\Enumeration\\MultitonInterface", "doc": "&quot;The interface implemented by Java-style enumeration instances.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method_key", "name": "Eloquent\\Enumeration\\MultitonInterface::key", "doc": "&quot;Returns the string key of this member.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method_anyOf", "name": "Eloquent\\Enumeration\\MultitonInterface::anyOf", "doc": "&quot;Check if this member is in the specified list of members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method_anyOfArray", "name": "Eloquent\\Enumeration\\MultitonInterface::anyOfArray", "doc": "&quot;Check if this member is in the specified list of members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method___toString", "name": "Eloquent\\Enumeration\\MultitonInterface::__toString", "doc": "&quot;Returns a string representation of this member.&quot;"},
            
            {"type": "Interface", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/ValueMultitonInterface.html", "name": "Eloquent\\Enumeration\\ValueMultitonInterface", "doc": "&quot;The interface implemented by Java-style enumeration instances with a value.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\ValueMultitonInterface", "fromLink": "Eloquent/Enumeration/ValueMultitonInterface.html", "link": "Eloquent/Enumeration/ValueMultitonInterface.html#method_value", "name": "Eloquent\\Enumeration\\ValueMultitonInterface::value", "doc": "&quot;Returns the value of this member.&quot;"},
            
            
            {"type": "Class", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/AbstractEnumeration.html", "name": "Eloquent\\Enumeration\\AbstractEnumeration", "doc": "&quot;Abstract base class for C++ style enumerations.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/AbstractMultiton.html", "name": "Eloquent\\Enumeration\\AbstractMultiton", "doc": "&quot;Abstract base class for Java-style enumerations.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberByKey", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberByKey", "doc": "&quot;Returns a single member by string key.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberByKeyWithDefault", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberByKeyWithDefault", "doc": "&quot;Returns a single member by string key. Additionally returns a default if\nno associated member is found.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberOrNullByKey", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberOrNullByKey", "doc": "&quot;Returns a single member by string key. Additionally returns null if the\nsupplied key is null.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberBy", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberBy", "doc": "&quot;Returns a single member by comparison with the result of an accessor\nmethod.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberByWithDefault", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberByWithDefault", "doc": "&quot;Returns a single member by comparison with the result of an accessor\nmethod. Additionally returns a default if no associated member is found.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberOrNullBy", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberOrNullBy", "doc": "&quot;Returns a single member by comparison with the result of an accessor\nmethod. Additionally returns null if the supplied value is null.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberByPredicate", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberByPredicate", "doc": "&quot;Returns a single member by predicate callback.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_memberByPredicateWithDefault", "name": "Eloquent\\Enumeration\\AbstractMultiton::memberByPredicateWithDefault", "doc": "&quot;Returns a single member by predicate callback. Additionally returns a\ndefault if no associated member is found.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_members", "name": "Eloquent\\Enumeration\\AbstractMultiton::members", "doc": "&quot;Returns an array of all members in this multiton.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_membersBy", "name": "Eloquent\\Enumeration\\AbstractMultiton::membersBy", "doc": "&quot;Returns a set of members by comparison with the result of an accessor\nmethod.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_membersByPredicate", "name": "Eloquent\\Enumeration\\AbstractMultiton::membersByPredicate", "doc": "&quot;Returns a set of members by predicate callback.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method___callStatic", "name": "Eloquent\\Enumeration\\AbstractMultiton::__callStatic", "doc": "&quot;Maps static method calls to members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_key", "name": "Eloquent\\Enumeration\\AbstractMultiton::key", "doc": "&quot;Returns the string key of this member.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_anyOf", "name": "Eloquent\\Enumeration\\AbstractMultiton::anyOf", "doc": "&quot;Check if this member is in the specified list of members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method_anyOfArray", "name": "Eloquent\\Enumeration\\AbstractMultiton::anyOfArray", "doc": "&quot;Check if this member is in the specified list of members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractMultiton", "fromLink": "Eloquent/Enumeration/AbstractMultiton.html", "link": "Eloquent/Enumeration/AbstractMultiton.html#method___toString", "name": "Eloquent\\Enumeration\\AbstractMultiton::__toString", "doc": "&quot;Returns a string representation of this member.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/AbstractValueMultiton.html", "name": "Eloquent\\Enumeration\\AbstractValueMultiton", "doc": "&quot;Abstract base class for Java-style enumerations with a value.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractValueMultiton", "fromLink": "Eloquent/Enumeration/AbstractValueMultiton.html", "link": "Eloquent/Enumeration/AbstractValueMultiton.html#method_memberByValue", "name": "Eloquent\\Enumeration\\AbstractValueMultiton::memberByValue", "doc": "&quot;Returns a single member by value.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractValueMultiton", "fromLink": "Eloquent/Enumeration/AbstractValueMultiton.html", "link": "Eloquent/Enumeration/AbstractValueMultiton.html#method_memberByValueWithDefault", "name": "Eloquent\\Enumeration\\AbstractValueMultiton::memberByValueWithDefault", "doc": "&quot;Returns a single member by value. Additionally returns a default if no\nassociated member is found.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractValueMultiton", "fromLink": "Eloquent/Enumeration/AbstractValueMultiton.html", "link": "Eloquent/Enumeration/AbstractValueMultiton.html#method_memberOrNullByValue", "name": "Eloquent\\Enumeration\\AbstractValueMultiton::memberOrNullByValue", "doc": "&quot;Returns a single member by value. Additionally returns null if the\nsupplied value is null.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractValueMultiton", "fromLink": "Eloquent/Enumeration/AbstractValueMultiton.html", "link": "Eloquent/Enumeration/AbstractValueMultiton.html#method_membersByValue", "name": "Eloquent\\Enumeration\\AbstractValueMultiton::membersByValue", "doc": "&quot;Returns a set of members matching the supplied value.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\AbstractValueMultiton", "fromLink": "Eloquent/Enumeration/AbstractValueMultiton.html", "link": "Eloquent/Enumeration/AbstractValueMultiton.html#method_value", "name": "Eloquent\\Enumeration\\AbstractValueMultiton::value", "doc": "&quot;Returns the value of this member.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/EnumerationInterface.html", "name": "Eloquent\\Enumeration\\EnumerationInterface", "doc": "&quot;The interface implemented by C++ style enumeration instances.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Enumeration\\Exception", "fromLink": "Eloquent/Enumeration/Exception.html", "link": "Eloquent/Enumeration/Exception/ExtendsConcreteException.html", "name": "Eloquent\\Enumeration\\Exception\\ExtendsConcreteException", "doc": "&quot;The supplied member extends an already concrete base class.&quot;"},
                    
            {"type": "Class", "fromName": "Eloquent\\Enumeration\\Exception", "fromLink": "Eloquent/Enumeration/Exception.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "doc": "&quot;The interface implemented by exceptions that are thrown when an undefined\nmember is requested.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "fromLink": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html#method_className", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface::className", "doc": "&quot;Get the class name.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "fromLink": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html#method_property", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface::property", "doc": "&quot;Get the property name.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface", "fromLink": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html", "link": "Eloquent/Enumeration/Exception/UndefinedMemberExceptionInterface.html#method_value", "name": "Eloquent\\Enumeration\\Exception\\UndefinedMemberExceptionInterface::value", "doc": "&quot;Get the value of the property used to search for the member.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/MultitonInterface.html", "name": "Eloquent\\Enumeration\\MultitonInterface", "doc": "&quot;The interface implemented by Java-style enumeration instances.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method_key", "name": "Eloquent\\Enumeration\\MultitonInterface::key", "doc": "&quot;Returns the string key of this member.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method_anyOf", "name": "Eloquent\\Enumeration\\MultitonInterface::anyOf", "doc": "&quot;Check if this member is in the specified list of members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method_anyOfArray", "name": "Eloquent\\Enumeration\\MultitonInterface::anyOfArray", "doc": "&quot;Check if this member is in the specified list of members.&quot;"},
                    {"type": "Method", "fromName": "Eloquent\\Enumeration\\MultitonInterface", "fromLink": "Eloquent/Enumeration/MultitonInterface.html", "link": "Eloquent/Enumeration/MultitonInterface.html#method___toString", "name": "Eloquent\\Enumeration\\MultitonInterface::__toString", "doc": "&quot;Returns a string representation of this member.&quot;"},
            
            {"type": "Class", "fromName": "Eloquent\\Enumeration", "fromLink": "Eloquent/Enumeration.html", "link": "Eloquent/Enumeration/ValueMultitonInterface.html", "name": "Eloquent\\Enumeration\\ValueMultitonInterface", "doc": "&quot;The interface implemented by Java-style enumeration instances with a value.&quot;"},
                                                        {"type": "Method", "fromName": "Eloquent\\Enumeration\\ValueMultitonInterface", "fromLink": "Eloquent/Enumeration/ValueMultitonInterface.html", "link": "Eloquent/Enumeration/ValueMultitonInterface.html#method_value", "name": "Eloquent\\Enumeration\\ValueMultitonInterface::value", "doc": "&quot;Returns the value of this member.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


