<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* quickreply_editor.html */
class __TwigTemplate_cdc27675a38b078101609359496c11e88d132dafd1dada7b2b3d8e0239d85bad extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<form method=\"post\" action=\"";
        echo ($context["U_QR_ACTION"] ?? null);
        echo "\" id=\"qr_postform\">
";
        // line 2
        // line 3
        echo "\t<div class=\"panel\">
\t\t<div class=\"inner\">
\t\t\t\t<h2 class=\"quickreply-title\">";
        // line 5
        echo $this->extensions['phpbb\template\twig\extension']->lang("QUICKREPLY");
        echo "</h2>
\t\t\t\t<fieldset class=\"fields1\">
\t\t\t\t";
        // line 7
        // line 8
        echo "\t\t\t\t\t<dl style=\"clear: left;\">
\t\t\t\t\t\t<dt><label for=\"subject\">";
        // line 9
        echo $this->extensions['phpbb\template\twig\extension']->lang("SUBJECT");
        echo $this->extensions['phpbb\template\twig\extension']->lang("COLON");
        echo "</label></dt>
\t\t\t\t\t\t<dd><input type=\"text\" name=\"subject\" id=\"subject\" size=\"45\" maxlength=\"124\" tabindex=\"2\" value=\"";
        // line 10
        echo ($context["SUBJECT"] ?? null);
        echo "\" class=\"inputbox autowidth\" /></dd>
\t\t\t\t\t</dl>
\t\t\t\t";
        // line 12
        // line 13
        echo "\t\t\t\t<div id=\"message-box\" class=\"message-box\">
\t\t\t\t\t<textarea style=\"height: 9em;\" name=\"message\" rows=\"7\" cols=\"76\" tabindex=\"3\" class=\"inputbox\"></textarea>
\t\t\t\t</div>
\t\t\t\t";
        // line 16
        // line 17
        echo "\t\t\t\t</fieldset>
\t\t\t\t<fieldset class=\"submit-buttons\">
\t\t\t\t\t";
        // line 19
        echo ($context["S_FORM_TOKEN"] ?? null);
        echo "
\t\t\t\t\t";
        // line 20
        echo ($context["QR_HIDDEN_FIELDS"] ?? null);
        echo "
\t\t\t\t\t<input type=\"submit\" accesskey=\"f\" tabindex=\"6\" name=\"preview\" value=\"";
        // line 21
        echo $this->extensions['phpbb\template\twig\extension']->lang("FULL_EDITOR");
        echo "\" class=\"button2\" id=\"qr_full_editor\" />&nbsp;
\t\t\t\t\t<input type=\"submit\" accesskey=\"s\" tabindex=\"7\" name=\"post\" value=\"";
        // line 22
        echo $this->extensions['phpbb\template\twig\extension']->lang("SUBMIT");
        echo "\" class=\"button1\" />&nbsp;
\t\t\t\t</fieldset>
\t\t</div>
\t</div>
";
        // line 26
        // line 27
        echo "</form>
";
    }

    public function getTemplateName()
    {
        return "quickreply_editor.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 27,  96 => 26,  89 => 22,  85 => 21,  81 => 20,  77 => 19,  73 => 17,  72 => 16,  67 => 13,  66 => 12,  61 => 10,  56 => 9,  53 => 8,  52 => 7,  47 => 5,  43 => 3,  42 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "quickreply_editor.html", "");
    }
}
