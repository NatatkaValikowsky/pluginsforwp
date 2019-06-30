<?php

/*
 * Plugin Name: Текстовый виджет от VN
 * Description: Текстовый виджет позволит вставить в сайдбар текст, верстку HTML или шорткод
 * Version: 1.0
 * Author: NatatkaValikowsky
 * Author URI: https://github.com/NatatkaValikowsky
 */

/**
 * Class VN_text_class
 * Класс плагина
 */
class VN_text_class
{
    /**
     * @var null
     * Хранит экземпляр класса
     */
    private static $_instance = null;

    /**
     * @return null
     * Возвращает экземпляр класса VN_text_class
     */
    public static function GetInstance()
    {
        if (is_null(VN_text_class::$_instance)) VN_text_class::$_instance = new VN_text_class();
        return VN_text_class::$_instance;
    }

    /**
     * VN_text_class constructor.
     */
    public function __construct()
    {
        if (function_exists('add_action')) {
            add_action('widgets_init', [$this, 'VN_register_widget']);
        }
    }

    /**
     * Функция регистрирует виджет
     */
    public function VN_register_widget()
    {
        register_widget('VN_widget_text');
    }
}

/**
 * Class VN_widget_text
 * Класс виджета
 */
class VN_widget_text extends WP_Widget
{
    /**
     * VN_widget_text constructor.
     * если 1 и более аргументов - WordPress ошибка
     */
    public function __construct()
    {
        $widget_options = [
            'classname' => 'VN_widget_text',
            'description' => __('Добавляет виджет с текстом, HTML-версткой или шорткодом'),
        ];

        parent::__construct('VN_widget_text', __('VN текстовый виджет'), $widget_options);
    }

    public function widget($args, $instance)
    {
        $title = $instance['title'];

        echo $args['before_widget'];

        echo $args['before_title'] . $title . $args['after_title'];

        do_shortcode($instance['text']);

        echo $args['after_widget'];

    }

    public function form($instance)
    {
        $instance = wp_parse_args(
            $instance,
            array(
                'title' => __('New title', 'VN_widget_text_domain'),
                'text' => __('', 'VN_widget_text_domain')
            )
        );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        </p>
        <p>
            <input class="VN_widget_title"
                   id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text"
                   value="<?php echo esc_attr($instance['title']); ?>"
            >
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:'); ?></label>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('text'); ?>"
                   name="<?php echo $this->get_field_name('text'); ?>"
                   type="text"
                   value="<?php echo esc_attr($instance['text']); ?>"
            >
        </p>
        <?php
    }
}

$VN_text = VN_text_class::GetInstance();
