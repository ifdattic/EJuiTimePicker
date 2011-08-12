<?php
/**
 * EJuiTimePicker class file.
 * 
 * @author Andrew M. <andrew.web@ifdattic.com>
 * @copyright Copyright &copy; 2011 Andrew M.
 * @license Licensed under MIT license. http://ifdattic.com/MIT-license.txt
 * @version 1.0
 */

/**
 * EJuiTimePicker displays a datepicker, timepicker or both.
 * 
 * @author Andrew M. <andrew.web@ifdattic.com>
 */
Yii::import( 'zii.widgets.jui.CJuiDatePicker' );
class EJuiTimePicker extends CJuiDatePicker
{
  /**
   * Filename of extensions assets.
   */
  const ASSETS_NAME = '/jquery-ui-timepicker-addon';
  
  /**
   * Filename of localization assets.
   */
  const LOCALIZATION_NAME = '/localization/jquery-ui-timepicker-';
  
  /**
   * @var string default mode of timepicker addon. 
   */
  public $mode = 'datetime';
  
  /**
   * @var array options to overwrite when using time picker.
   */
  public $timeOptions = array();
  
  /**
   * @var array html options to overwrite when using time picker.
   */
  public $timeHtmlOptions = array();
  
  /**
   * Initialize widget.
   */
  public function init()
  {
    if( !in_array( $this->mode, array( 'date', 'time', 'datetime' ) ) )
      throw new CException( 'unknown mode "' . $this->mode . '"' );

    if( !isset( $this->language ) )
      $this->language = Yii::app()->getLanguage();

    // Overwrite options for time picker
    if( $this->mode === 'time' )
    {
      $this->options = array_merge( $this->options, $this->timeOptions );
      $this->htmlOptions = array_merge( $this->htmlOptions, $this->timeHtmlOptions );
    }
    
    return parent::init();
  }
  
  /**
   * Generate timepicker input.
   */
  public function run()
  {
    list( $name, $id ) = $this->resolveNameID();
    
    if( isset( $this->htmlOptions['id'] ) )
      $id = $this->htmlOptions['id'];
    else
      $this->htmlOptions['id'] = $id;
    if( isset( $this->htmlOptions['name'] ) )
      $name = $this->htmlOptions['name'];
    else
      $this->htmlOptions['name'] = $name;
    
    if( $this->hasModel() )
      echo CHtml::activeTextField( $this->model, $this->attribute, $this->htmlOptions );
    else
      echo CHtml::textField( $name, $this->value, $this->htmlOptions );
    
    $options = CJavaScript::encode( $this->options );
    
    $js = "jQuery('#{$id}').{$this->mode}picker({$options});";

    if( isset( $this->language ) && $this->language != 'en_us' )
    {
      $this->registerScriptFile( $this->i18nScriptFile );
      $js = "jQuery('#{$id}').{$this->mode}picker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['{$this->language}'], {$options}));";
    }
    
    // Publish extension assets
    $assets = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias(
      'ext.EJuiTimePicker' ) . '/assets' );
    $cs = Yii::app()->getClientScript();
    $cs->registerCssFile( $assets . self::ASSETS_NAME . '.css' );
    $cs->registerScriptFile( $assets . self::ASSETS_NAME . '.js',
      CClientScript::POS_END );
    
    // Run extension
    $cs->registerScript( __CLASS__, $this->defaultOptions ? 'jQuery.{$this->mode}picker.setDefaults(' . CJavaScript::encode( $this->defaultOptions ) . ');' : '' );
    $cs->registerScript( __CLASS__ . '#' . $id, $js );
    
    // // Add localization file if it exists
    $localization = $assets . self::LOCALIZATION_NAME . $this->language . '.js';
    if( file_exists( Yii::getPathOfAlias( 'webroot' ) . $localization ) )
      $cs->registerScriptFile( $localization, CClientScript::POS_END );
  }
}
?>