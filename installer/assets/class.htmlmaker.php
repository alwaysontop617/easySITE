<?php if (!defined('INST_BASEDIR')) {
    die('Direct access is not allowed!');
}

    /* ====================================================================
    *
    *                            PHP Setup Wizard
    *
    *                          -= HTML/FORM MAKER =-
    *
    *  ================================================================= */


    /**
     *  Generates HTML for the installation process.
     */
    class Inst_HtmlMaker
    {
        private $queue; // Contains the "to-become" generated html content
        private $debug; // Contains data to show at the start of the page
        private $formopen; // The value of currently open form
        private $formclose; // Indicates a form that will be closed next
        private $element; // Counter for check/radiobox javascript generation
        private $tableCols; // Number of columns in a open table
        private $colCount; // Number of columns already added to a row

        private $hideDisabled;
        private $hideIsHidden;
        private $useStepWait;

        /**
         *  Generates HTML for the installation process.
         */
        public function Inst_HtmlMaker()
        {
            $this->queue = [];
            $this->debug = [];
            $this->formopen = 0; // must match formclose here!
            $this->formclose = 0; // must match formopen here!
            $this->element = 1;
            $this->tableCols = 1;
            $this->colCount = 0;

            $this->hideDisabled = true;
            $this->hideIsHidden = true;
            $this->useStepWait = true;
        }


        /********************************[ PROCESS DIALOG ]********************************/

        /**
         *  Should disabled steps be hidden from "process" box.
         */
        public function HideDisabledSteps($hideValue)
        {
            $this->hideDisabled = $hideValue;
        }

        /**
         *  Should ishiddenped steps be hidden from "process" box.
         */
        public function HideIsHiddenSteps($hideValue)
        {
            $this->hideIsHidden = $hideValue;
        }

        /**
         *  In normal process, the steps "to become" are put on a "wait" state
         *  in the process dialog. If this is set to false, all enabled steps
         *  will be displayed as "done".
         */
        public function UseStepWait($hideValue)
        {
            $this->useStepWait = $hideValue;
        }


        /********************************[ MESSAGE BOXES ]********************************/

        /**
         *  Add message to the page.
         */
        public function MessageBox($message, $icon = 'info', $optional = [])
        {
            // Default is INFO if incorrect icon is selected
            $icons = ['success', 'warning', 'info', 'error', 'dberror', 'zoom'];
            $attribs = $this->GetAttributeString($optional);

            if (is_array($message)) {
                $message['icon'] = (in_array($message['icon'], $icons)) ? $message['icon'] : 'info';
                if (strlen($message['msg']) > 0) {
                    $this->queue[] = '<div class="msg '.$message['icon'].'"'.$attribs.'>'.$message['msg'].'</div>'."\n";
                }
            } else {
                $icon = (in_array($icon, $icons)) ? $icon : 'info';
                if (strlen($message) > 0) {
                    $this->queue[] = '<div class="msg '.$icon.'"'.$attribs.'>'.$message.'</div>'."\n";
                }
            }
        }

        /**
         *  Add success message box to the page.
         */
        public function SuccessBox($message, $optional = [])
        {
            return $this->MessageBox($message, 'success', $optional);
        }

        /**
         *  Add error message box to the page.
         */
        public function ErrorBox($message, $optional = [])
        {
            return $this->MessageBox($message, 'error', $optional);
        }

        /**
         *  Add error message box to the page.
         */
        public function ErrorDatabaseBox($message, $optional = [])
        {
            return $this->MessageBox('<span>MySQL:</span> '.$message, 'dberror', $optional);
        }

        /**
         *  Add warning message box to the page.
         */
        public function WarningBox($message, $optional = [])
        {
            return $this->MessageBox($message, 'warning', $optional);
        }

        /**
         *  Add info message box to the page.
         */
        public function InfoBox($message, $optional = [])
        {
            return $this->MessageBox($message, 'info', $optional);
        }


        /********************************[ TEXTS AND HEADINGS ]********************************/

        /**
         *  Set a < H? > heading.
         */
        public function Heading($headingNr, $title, $icon = '', $optional = [])
        {
            $class = (strlen($icon) > 0) ? ' class="hicon '.$icon.'"' : '';
            $attribs = $this->GetAttributeString($optional);

            if (strlen($title) > 0) {
                $this->queue[] = '<h'.$headingNr.$class.$attribs.'>'.$title.'</h'.$headingNr.'>'."\n";
            }
        }

        /**
         *  Add main title on the page.
         */
        public function MainTitle($title, $icon = '', $optional = [])
        {
            $this->Heading(1, $title, $icon, $optional);
        }

        /**
         *  Add sub title on the page.
         */
        public function SubTitle($title, $icon = '', $optional = [])
        {
            $this->Heading(2, $title, $icon, $optional);
        }

        /**
         *  Add label on the page.
         */
        public function Label($title, $icon = '', $optional = [])
        {
            $this->Heading(3, $title, $icon, $optional);
        }

        /**
         *  Add paragraph to the page.
         */
        public function Paragraph($text = '&nbsp;', $class = '')
        {
            if (is_array($class)) {
                $attribs = $this->GetAttributeString($class);
            } else {
                $attribs = (strlen($class) > 0) ? ' class="'.$class.'"' : '';
            }

            if (strlen($text) > 0) {
                $this->queue[] = '<p'.$attribs.'>'.$text.'</p>'."\n";
            }
        }

        /**
         *  Add quotation to the page.
         */
        public function Quotation($text, $class = 'quote')
        {
            if (is_array($class)) {
                $attribs = $this->GetAttributeString($class);
            } else {
                $attribs = (strlen($class) > 0) ? ' class="'.$class.'"' : '';
            }

            if (strlen($text) > 0) {
                $this->queue[] = '<div'.$attribs.'>'.$text.'</div>'."\n";
            }
        }

        /**
         *  Add textarea to read content from ONLY, call
         *  FormTextarea() if you want it for a form!
         */
        public function Textarea($text, $class = 'display')
        {
            if (is_array($class)) {
                $attribs = $this->GetAttributeString($class);
            } else {
                $attribs = (strlen($class) > 0) ? ' class="'.$class.'"' : '';
            }

            if (strlen($text) > 0) {
                $this->queue[] = '<div class="textbox"><textarea'.$attribs.' readonly>'.$text.'</textarea></div>'."\n";
            }
        }

        /**
         *  Create an <a name="?" /> anchor so urls with bookmarks.
         */
        public function Bookmark($name)
        {
            if (strlen($name) > 0) {
                $this->queue[] = '<a name="'.$name.'"></a>';
            }
        }

        /********************************[ FORMS ]********************************/


        /**
         *  Begin a form on the page. $goto parameter should be an array
         *  in the form : array('key'=>'value') to get hidden fields.
         */
        public function FormStart($goto = false, $optional = [])
        {
            $attribs = $this->GetAttributeString($optional);
            $anchor = (isset($optional['#'])) ? '#'.$optional['#'] : '';


            // If 'formopen' and 'formclose' do not match each other, it means that an earlyer
            // opened form has not been closed. Thus, "FormClose()" will be called to close it
            // and increment 'formclose'. This is done in order to be able to generate "onClick"
            // methods with proper form-names automatically known.
            if ($this->formopen != $this->formclose) {
                $this->FormClose();
            }

            // Increment formopen, as now there is a open form!
            $this->formopen++;

            if (is_array($goto)) {
                $this->queue[] =
                    '<form name="form'.$this->formopen.'" action="'.INST_RUNSCRIPT.$anchor.'" method="post"'.$attribs.'>'."\n";

                foreach ($goto as $key => $value) {
                    $this->FormHidden($value, $key);
                }
            } else {
                $this->queue[] =
                    '<form name="form'.$this->formopen.'" action="'.INST_RUNSCRIPT.$goto.$anchor.'" method="post">'."\n";
            }
        }

        /**
         *  Add an input field.
         */
        public function FormHidden($value, $name = 'hidden', $optional = [])
        {
            $attribs = $this->GetAttributeString($optional);
            $this->queue[] =
                '<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$attribs.' />'."\n";
        }

        /**
         *  Add an input field.
         */
        public function FormInput($value, $name = 'input', $optional = [], $containerAddClass = '')
        {
            $attribs = $this->GetAttributeString($optional);
            $containerAddClass = (strlen($containerAddClass) > 0) ? ' '.$containerAddClass : '';
            $this->queue[] =
                '<div class="textbox'.$containerAddClass.'"><input type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$attribs.' /></div>'."\n";
        }

        /**
         *  Add an password field.
         */
        public function FormPassword($value, $name = 'password', $optional = [], $containerAddClass = '')
        {
            $attribs = $this->GetAttributeString($optional);
            $containerAddClass = (strlen($containerAddClass) > 0) ? ' '.$containerAddClass : '';
            $this->queue[] =
                '<div class="textbox'.$containerAddClass.'"><input type="password" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$attribs.' /></div>'."\n";
        }

        /**
         *  Add an textarea field.
         */
        public function FormTextarea($value, $name = 'input', $optional = [], $containerAddClass = '')
        {
            $attribs = $this->GetAttributeString($optional);
            $containerAddClass = (strlen($containerAddClass) > 0) ? ' '.$containerAddClass : '';
            $this->queue[] =
                '<div class="textbox'.$containerAddClass.'"><textarea id="'.$name.'" name="'.$name.'" '.$attribs.' />'.$value.'</textarea></div>'."\n";
        }

        /**
         *  Add an checkbox field.
         */
        public function FormCheckbox($value, $name = 'checkbox', $caption = '*no caption set*', $optional = [], $containerAddClass = '')
        {
            $nr = $this->element++;
            $attribs = $this->GetAttributeString($optional);
            $containerAddClass = (strlen($containerAddClass) > 0) ? ' '.$containerAddClass : '';

            $this->queue[] =
                '<div class="formchb'.$containerAddClass.'" '.
                'onclick="document.form'.$this->formopen.'.chb'.$nr.'.checked=!document.form'.$this->formopen.'.chb'.$nr.'.checked;">'.
                '<input type="checkbox" id="chb'.$nr.'" name="'.$name.'" value="'.$value.'"'.$attribs.' />'.
                '<span>'.$caption.'</span></div>'."\n";
        }

        /**
         *  Add an radiobox field.
         */
        public function FormRadiobox($value, $name = 'radiobox', $caption = '*no caption set*', $optional = [], $containerAddClass = '')
        {
            $nr = $this->element++;
            $attribs = $this->GetAttributeString($optional);
            $containerAddClass = (strlen($containerAddClass) > 0) ? ' '.$containerAddClass : '';

            $this->queue[] =
                '<div class="formrbt'.$containerAddClass.'"  onclick="document.form'.$this->formopen.'.rbt'.$nr.'.checked=true;">'.
                '<input type="radio" id="rbt'.$nr.'" name="'.$name.'" value="'.$value.'"'.$attribs.' />'.
                '<span>'.$caption.'</span></div>'."\n";
        }

        /**
         *  Add submit button to form.
         */
        public function FormSubmit($caption, $name = 'submit', $optional = [])
        {
            $attribs = $this->GetAttributeString($optional);
            $this->queue[] =
                '<input type="submit" class="btn" name="'.$name.'" value="'.$caption.'"'.$attribs.' />'."\n";
        }

        /**
         *  Add reset.
         */
        public function FormReset($caption, $name = 'reset', $optional = [])
        {
            $attribs = $this->GetAttributeString($optional);
            $this->queue[] =
                '<input type="reset" class="btn" name="'.$name.'" value="'.$caption.'"'.$attribs.' />'."\n";
        }

        /**
         *  Add button with javascript "go to url" functionality.
         */
        public function FormButton($caption, $goto = ['key' => 'value'], $name = 'button', $optional = [])
        {
            $attribs = $this->GetAttributeString($optional);
            $url = '';
            $serp = '?';
            foreach ($goto as $key => $val) {
                $url .= $serp.$key.'='.$val;
                $serp = '&';
            }
            $this->queue[] =
                '<button type="button" class="btn" name="'.$name.'"'.$attribs." onclick=\"javascript:location.href='".$url."'\" >".$caption.'</button>'."\n";
        }

        /**
         *  Close a form opened.
         */
        public function FormClose()
        {
            $this->queue[] =
                '</form>'."\n";

            // Form has been closed, increment "number of forms closed"
            $this->formclose++;
        }

        /**
         *  All elements support optional attributes, which this method
         *  translates into one string that will be added to the elements.
         */
        public function GetAttributeString($attributeArray)
        {
            $attribs = '';
            foreach ($attributeArray as $key => $val) {
                // Ignore bookmarks, they are for URL's only!
                if (!is_numeric($key)) {
                    if ($key != '#') {
                        $attribs .= ' '.$key.'="'.$val.'"';
                    }
                } else {
                    $attribs .= ' '.$val;
                }
            }

            return $attribs;
        }


        /********************************[ TABLES ]********************************/

        /**
         *  Start a table that will have spesific number of columns.
         */
        public function StartTable($columnCount, $optional = [])
        {
            $this->tableCols = $columnCount;
            $this->colCount = 0;

            $attribs = $this->GetAttributeString($optional);
            $this->queue[] =
                '<table'.$attribs.'>'."\n";
        }

        /**
         *  Add one element or an array of elements. This function will know
         *  how many table data are supposed to be in each row and will keep
         *  track of them as more items are added.
         */
        public function AddTableData($element = '&nbsp;', $optionalTD = [], $optionalTR = [])
        {
            // If this is an array of elements, go through the elements
            // and recursivly call the same method again only with a single
            // value (or another array)
            if (is_array($element)) {
                foreach ($element as $elm) {
                    $this->AddTableData($elm, $optionalTD, $optionalTR);
                }
            } else {
                $attribsTD = $this->GetAttributeString($optionalTD);
                $attribsTR = $this->GetAttributeString($optionalTR);

                // If the column count is zero, then a row has to be opened
                if ($this->colCount == 0) {
                    $this->queue[] = '<tr'.$attribsTR.'>'."\n";
                }

                // Add table data to row
                $this->colCount++;
                $this->queue[] = '<td'.$attribsTD.'>'.$element.'</td>'."\n";

                // If the number of added columns matches the number of
                // total columns, close the row and reset column counter
                if ($this->colCount == $this->tableCols) {
                    $this->colCount = 0;
                    $this->queue[] = '</tr>'."\n";
                }
            }
        }

        /**
         *  Closes an open table. If there are missing table data in the last
         *  row, this function will make sure they are added with &nbsp; as value.
         */
        public function EndTable()
        {
            // While the number of column count is not zero, keep adding empty
            // table data into the row until filled, then close the table
            while ($this->colCount != 0) {
                $this->AddTableData('&nbsp;');
            }

            $this->queue[] = '</table>'."\n";
        }


        /********************************[ DISPLAY THE PAGE ]********************************/

        /**
         *  Generate HTML from all the added components and display on
         *  the page itself. Current step must be passed.
         */
        public function ShowPage($currentStepKey, $dieWhenDone = true, $doneStepsAreLinks = true, $pageTitle = false)
        {
            global $config;

            // If the title has not been overridden, use the one defined in config
            if ($pageTitle === false || strlen(trim($pageTitle)) == 0) {
                $pageTitle = $config['installer_title_name'];
            }

            // Start the page
            $this->HtmlHeader($currentStepKey, $pageTitle, $doneStepsAreLinks);

            // If something has to be shown on top first
            if (count($this->debug) > 0) {
                $this->Paragraph();
                $this->MainTitle('Debugging', 'debug');
                foreach ($this->debug as $debug) {
                    if (is_array($debug['item'])) {
                        // Only display this if there is some data to check
                        if (count($debug['item']) > 0) {
                            $this->MessageBox('<b>'.$debug['title'].'</b><br /><pre style="font-size:11px; line-height:10px;">'.print_r($debug['item'], true).'</pre>', 'zoom');
                        }
                    } else {
                        $this->MessageBox('<b>'.$debug['title'].'</b><br /><pre style="font-size:11px; line-height:10px;">'.$debug['item'].'</pre>', 'zoom');
                    }
                }
            }

            // Display parts of the page in the order which
            // they were added
            if (count($this->queue) > 0) {
                foreach ($this->queue as $html) {
                    echo $html;
                }
            }

            // Close the page
            $this->HtmlFooter();

            // Should the script stop running when
            // the page has been created?
            if ($dieWhenDone) {
                die();
            } else {
                $this->ClearHtmlQueue();
            }
        }

        /**
         *  This resets all the html that has been added to the queue.
         */
        public function ClearHtmlQueue()
        {
            $this->queue = null;
            $this->queue = [];
        }


        /********************************[ FORMATTING OUTSIDE ]********************************/

        /**
         *  Add some queue-item to the html queue.
         */
        public function AddToQueue($item)
        {
            $this->queue[] = $item;
        }

        /**
         *  Update some existing data.
         */
        public function UpdateQueueAtIndex($index, $item)
        {
            $this->queue[$index] = $item;
        }

        /**
         *  Get the current queue index.
         */
        public function GetQueueIndex()
        {
            return count($this->queue) - 1;
        }

        /**
         *  This method will remove or "pop" the most recently added item
         *  and return it. It can be usefull if you need to get for instance
         *  a RadioBox or CheckBox and put into some container like a Table.
         */
        public function PopQueue()
        {
            return array_pop($this->queue);
        }

        /**
         *  Add anything to debug queue, when the page is shown to
         *  the user, this queue will display this at the top of the
         *  page.
         */
        public function AddToDebug($title, $debug)
        {
            $this->debug[] = ['title' => $title, 'item' => $debug];
        }

        /**
         *  Put <span></span> tags around something and return.
         */
        public function Span($value, $class = '')
        {
            $class = (strlen($class) > 0) ? ' class="'.$class.'"' : '';

            return '<span'.$class.'>'.$value.'</span>';
        }

        /**
         *  Make something "emphazis" and return.
         */
        public function Emphasize($value)
        {
            return $this->Span($value, 'emphazis');
        }

        /**
         *  Make something "discrete" and return.
         */
        public function Discrete($value)
        {
            return $this->Span($value, 'descrete');
        }

        /**
         *  Make something "must" and return.
         */
        public function Must($value)
        {
            return $this->Span($value, 'must');
        }

        /**
         *  Get a flag image returned in HTML.
         */
        public function GetFlagHtml($countryCode, $link = false, $optional = ['alt' => '', 'title' => ''])
        {
            // First do a check if the file exists
            $imageFile = INST_RUNFOLDER.'images'.DIRECTORY_SEPARATOR.'flags'.DIRECTORY_SEPARATOR.$countryCode.'.png';
            if (is_file($imageFile)) {
                // Then revert the slashes to / slash as that is the slash used
                // in webbrowsers. So going from "filesystem" to "browser" here
                $imageFile = str_replace('\\', '/', $imageFile);

                // Get attributes for this image
                $attribs = $this->GetAttributeString($optional);

                // Wrap in HTML and retrn
                $img = '<img src="'.$imageFile.'" '.$attribs.' />';
                if (strlen($link) > 0) {
                    return '<a href="'.$link.'">'.$img.'</a>';
                } else {
                    return $img;
                }
            }
        }


        /********************************[ HTML TEMPLATES ]********************************/

        /**
         *  Get the HTML header of the installer template.
         */
        public function HtmlHeader($currentStepKey = '', $html_title = 'Database Installer', $doneStepsAreLinks = true)
        {
            ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $html_title; ?></title>
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta name="robots" content="index,follow" />
<meta name="author" content="Thorsteinn" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="<?php echo INST_RUNFOLDER ?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo INST_RUNFOLDER ?>css/icons.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mootools/1.6.0/mootools-core-compat.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.min.css">

</head>
<body>
	<div class="page-header">
  <h1>EasySite Installer <small>Tecflare Corporation</small></h1>
</div>
<div id="container">
	<div id="steps">
	<ul class="steps">
<?php 
        global $steps;

            $overCurrent = false;
            foreach ($steps as $key => $step) {
                $disabled = false;
                $ishidden = false;

            // If the step is "overview", show the settings icon
            if ($key == STEP_SETTOVERVIEW) {
                if ($key == $currentStepKey) {
                    echo '<li class="settings"><a style="btn btn-primary" href="?step='.$key.'"><b>'.$step['title'].'</b></a></li>'."\n";
                } else {
                    echo '<li class="settings"><a style="btn btn-primary" href="?step='.$key.'">'.$step['title'].'</a></li>'."\n";
                }
                continue;
            }

            // Do not show disabled steps, unless enabled manually
            if (isset($step['enabled']) && !$step['enabled']) {
                $disabled = true;
                if ($this->hideDisabled) {
                    continue;
                }
            }

            // If currently displaying the selected step
            if ($key == $currentStepKey) {
                echo '<li class="now"><a style="btn btn-primary" href="?step='.$key.'">'.$step['title'].'</a></li>'."\n";
                $overCurrent = true;
            } else {
                // ishidden steps are only shown when they are set to current step! Thus if successful,
                // the ishidden steps are never shown, just jumped over - unless manually changed
                if (isset($step['ishidden']) && $step['ishidden']) {
                    $ishidden = true;
                    if ($this->hideIsHidden) {
                        continue;
                    }
                }

                // If not yet displayed current step, this step has then been done already - so display OK status.
                // If it HAS passed over current step, this step is waiting to be "progressed too" so to speak
                if ($overCurrent) {
                    $class = ($this->useStepWait) ? 'wait' : 'okay';
                    if ($ishidden) {
                        $class = 'autoskip';
                    }
                    if ($disabled) {
                        $class = 'disabled';
                    }
                    echo '<li class="'.$class.'"><a href="?step='.$key.'">'.$step['title'].'</a></li>'."\n";
                } else {
                    $class = 'okay';
                    if ($ishidden) {
                        $class = 'autoskip';
                    }
                    if ($disabled) {
                        $class = 'disabled';
                    }

                    // When installer is done, the above steps are no longer available
                    if ($doneStepsAreLinks) {
                        echo '<li class="'.$class.'"><a href="?step='.$key.'">'.$step['title'].'</a></li>'."\n";
                    } else {
                        echo '<li class="'.$class.'"><a name="step_'.$key.'">'.$step['title'].'</a></li>'."\n";
                    }
                }
            }
            } ?>
	</ul>&nbsp;
	</div>

	<div id="content">
		<div id="installer">
<?php

        }

        /**
         *  Get the HTML footer of the installer template.
         */
        public function HtmlFooter()
        {
            ?>
		</div>
		<div id="footer">
			&copy; Tecflare Corporation 2007-<?php echo date('Y'); ?> All Rights Reserved
		</div>
	</div>
</div>

</body>
</html>
<?php

        }

        /**
         *  Get a <select> element with all timezones in it.
         */
        public function AddTimezoneDropdown($elementName, $selectedValue = '0')
        {
            $strblock = '<select name="'.$elementName.'">
<option value="-1200">(GMT-12:00) International Date Line West</option>
<option value="-1100">(GMT-11:00) Coordinated Universal Time-11</option>
<option value="-1100">(GMT-11:00) Samoa</option>
<option value="-1000">(GMT-10:00) Hawaii</option>
<option value="-900">(GMT-09:00) Alaska</option>
<option value="-800">(GMT-08:00) Baja California</option>
<option value="-800">(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="-700">(GMT-07:00) Arizona</option>
<option value="-700">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="-700">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="-6000">(GMT-06:00) Central America</option>
<option value="-600">(GMT-06:00) Central Time (US & Canada)</option>
<option value="-600">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="-600">(GMT-06:00) Saskatchewan</option>
<option value="-500">(GMT-05:00) Bogota, Lima, Quito</option>
<option value="-500">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="-500">(GMT-05:00) Indiana (East)</option>
<option value="-430">(GMT-04:30) Caracas</option>
<option value="-400">(GMT-04:00) Asuncion</option>
<option value="-400">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="-400">(GMT-04:00) Cuiaba</option>
<option value="-400">(GMT-04:00) Georgetown, La Paz, Manaus, San Juan</option>
<option value="-400">(GMT-04:00) Santiago</option>
<option value="-330">(GMT-03:30) Newfoundland</option>
<option value="-300">(GMT-03:00) Brasilia</option>
<option value="-300">(GMT-03:00) Buenos Aires</option>
<option value="-300">(GMT-03:00) Cayenne, Fortaleza</option>
<option value="-300">(GMT-03:00) Greenland</option>
<option value="-300">(GMT-03:00) Montevideo</option>
<option value="-200">(GMT-02:00) Coordinated Universal Time-02</option>
<option value="-200">(GMT-02:00) Mid-Atlantic</option>
<option value="-100">(GMT-01:00) Azores</option>
<option value="-100">(GMT-01:00) Cape Verde Is.</option>
<option value="0">(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
<option value="0">(GMT) Casablanca</option>
<option value="0">(GMT) Coordinated Universal Time</option>
<option value="0">(GMT) Monrovia, Reykjavik</option>
<option value="100">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="100">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="100">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="100">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
<option value="100">(GMT+01:00) West Central Africa</option>
<option value="200">(GMT+02:00) Amman</option>
<option value="200">(GMT+02:00) Athens, Bucharest, Istanbul</option>
<option value="200">(GMT+02:00) Beirut</option>
<option value="200">(GMT+02:00) Cairo</option>
<option value="200">(GMT+02:00) Harare, Pretoria</option>
<option value="200">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
<option value="200">(GMT+02:00) Jerusalem</option>
<option value="200">(GMT+02:00) Minsk</option>
<option value="200">(GMT+02:00) Windhoek</option>
<option value="300">(GMT+03:00) Baghdad</option>
<option value="300">(GMT+03:00) Kuwait, Riyadh</option>
<option value="300">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="300">(GMT+03:00) Nairobi</option>
<option value="330">(GMT+03:30) Tehran</option>
<option value="400">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="400">(GMT+04:00) Baku</option>
<option value="400">(GMT+04:00) Port Louis</option>
<option value="400">(GMT+04:00) Tbilisi</option>
<option value="400">(GMT+04:00) Yerevan</option>
<option value="430">(GMT+04:30) Kabul</option>
<option value="500">(GMT+05:00) Ekaterinburg</option>
<option value="500">(GMT+05:00) Islamabad, Karachi</option>
<option value="500">(GMT+05:00) Tashkent</option>
<option value="530">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="530">(GMT+05:30) Sri Jayawardenepura</option>
<option value="545">(GMT+05:45) Kathmandu</option>
<option value="600">(GMT+06:00) Astana</option>
<option value="600">(GMT+06:00) Dhaka</option>
<option value="600">(GMT+06:00) Novosibirsk</option>
<option value="630">(GMT+06:30) Vangon (Rangoon)</option>
<option value="700">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="700">(GMT+07:00) Krasnoyarsk</option>
<option value="800">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="800">(GMT+08:00) Irkutsk</option>
<option value="800">(GMT+08:00) Kuala Lumpur, Singapore</option>
<option value="800">(GMT+08:00) Perth</option>
<option value="800">(GMT+08:00) Taipei</option>
<option value="800">(GMT+08:00) Ulaanbaatar</option>
<option value="900">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="900">(GMT+09:00) Seoul</option>
<option value="900">(GMT+09:00) Yakutsk</option>
<option value="930">(GMT+09:30) Adelaide</option>
<option value="930">(GMT+09:30) Darwin</option>
<option value="1000">(GMT+10:00) Brisbane</option>
<option value="1000">(GMT+10:00) Canberra, Melbourne, Sydney</option>
<option value="1000">(GMT+10:00) Guam, Port Moresby</option>
<option value="1000">(GMT+10:00) Hobart</option>
<option value="1000">(GMT+10:00) Vladivostok</option>
<option value="1100">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
<option value="1200">(GMT+12:00) Auckland, Wellington</option>
<option value="1200">(GMT+12:00) Coordinated Universal Time+12</option>
<option value="1200">(GMT+12:00) Fiji</option>
<option value="1200">(GMT+12:00) Petropavlovsk-Kamchatsky</option>
<option value="1300">(GMT+13:00) Nukualofa</option>
</select>';

            if ($selectedValue !== false && strlen($selectedValue) > 0) {
                // The selected value is wrapped into " to make sure
                // that the value is not found partially in other values
                $selectedValue = '"'.$selectedValue.'"';

                // See if the selected value is in the string block
                $pos = strpos($strblock, $selectedValue);

                // If the selected value is found, the first option
                // is made "selected" by adding small string in it
                $insertStr = ' selected';
                if ($pos >= 0) {
                    $this->queue[] = substr($strblock, 0, $pos + strlen($selectedValue)).$insertStr.substr($strblock, $pos + strlen($selectedValue));
                }

                // If not found, the block is added unmodifed
                else {
                    $this->queue[] = $strblock;
                }
            } else {
                $this->queue[] = $strblock;
            }
        }
    }

?>