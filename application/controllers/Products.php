<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Products_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }

    // ****************************** View Page -- START ****************************** //

    // View Product Category;
    public function product_category()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'products/product_category/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Products_model->record_category_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Products_model->fetch_category_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Products_model->record_category_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Products_model->record_category_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Products_model->record_category_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_add_product_category'] = $this->lang->line('add_product_category');

        $this->load->view('category', $data);
    }

    // Add New Product Category;
    public function addproductcategory()
    {
        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_add_product_category'] = $this->lang->line('add_product_category');

        $this->load->view('add_product_category', $data);
    }

    // Edit Product Category;
    public function editproductcategory()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_add_product_category'] = $this->lang->line('add_product_category');
        $data['lang_delete_product_category'] = $this->lang->line('delete_product_category');
        $data['lang_edit_product_category'] = $this->lang->line('edit_product_category');

        $this->load->view('edit_product_category', $data);
    }

    // View Products;
    public function list_products()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'products/list_products/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Products_model->record_product_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Products_model->fetch_product_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Products_model->record_product_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Products_model->record_product_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Products_model->record_product_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_code'] = $this->lang->line('code');
        $data['lang_image'] = $this->lang->line('image');
        $data['lang_category'] = $this->lang->line('category');
        $data['lang_cost'] = $this->lang->line('cost');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_add_product'] = $this->lang->line('add_product');

        $this->load->view('products', $data);
    }

    // Add Product;
    public function addproduct()
    {
        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_code'] = $this->lang->line('code');
        $data['lang_image'] = $this->lang->line('image');
        $data['lang_category'] = $this->lang->line('category');
        $data['lang_cost'] = $this->lang->line('cost');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_add_product'] = $this->lang->line('add_product');
        $data['lang_select_product_category'] = $this->lang->line('select_product_category');
        $data['lang_purchase_price'] = $this->lang->line('purchase_price');
        $data['lang_retail_price'] = $this->lang->line('retail_price');
        $data['lang_product_image'] = $this->lang->line('product_image');
        $data['lang_browse'] = $this->lang->line('browse');

        $this->load->view('add_product', $data);
    }

    // Edit Product;
    public function editproduct()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_code'] = $this->lang->line('code');
        $data['lang_image'] = $this->lang->line('image');
        $data['lang_category'] = $this->lang->line('category');
        $data['lang_cost'] = $this->lang->line('cost');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_add_product'] = $this->lang->line('add_product');
        $data['lang_select_product_category'] = $this->lang->line('select_product_category');
        $data['lang_purchase_price'] = $this->lang->line('purchase_price');
        $data['lang_retail_price'] = $this->lang->line('retail_price');
        $data['lang_product_image'] = $this->lang->line('product_image');
        $data['lang_browse'] = $this->lang->line('browse');
        $data['lang_edit_product'] = $this->lang->line('edit_product');
        $data['lang_delete_product'] = $this->lang->line('delete_product');
        $data['lang_inventory_by_outlet'] = $this->lang->line('inventory_by_outlet');
        $data['lang_inventory_count'] = $this->lang->line('inventory_count');

        $this->load->view('edit_product', $data);
    }

    // Print Label;
    public function print_label()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'products/print_label/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Products_model->record_label_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Products_model->fetch_label_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Products_model->record_label_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Products_model->record_label_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Products_model->record_label_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data['lang_print_label_header'] = $this->lang->line('print_label_header');

        $this->load->view('print_label', $data);
    }

    // Search Product;
    public function searchProduct()
    {
        $code = $this->input->get('code');
        $name = $this->input->get('name');
        $category = $this->input->get('category');

        $data['search_code'] = $code;
        $data['search_name'] = $name;
        $data['search_category'] = $category;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_code'] = $this->lang->line('code');
        $data['lang_image'] = $this->lang->line('image');
        $data['lang_category'] = $this->lang->line('category');
        $data['lang_cost'] = $this->lang->line('cost');
        $data['lang_price'] = $this->lang->line('price');
        $data['lang_add_product'] = $this->lang->line('add_product');

        $this->load->view('search_product', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Product;
    public function deleteProduct()
    {
        $prod_id = $this->input->post('prod_id');
        $prod_name = $this->input->post('prod_name');

        if ($this->Constant_model->deleteData('products', $prod_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Eliminar Producto', "Producto eliminado con éxito : $prod_name."));
            redirect(base_url().'products/list_products');
        }
    }

    // Delete Product Category;
    public function deleteproductcategory()
    {
        $cat_id = $this->input->post('cat_id');
        $cat_name = $this->input->post('cat_name');

        if ($this->Constant_model->deleteData('category', $cat_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Eliminar categoría de producto', "Categoría de producto eliminada con éxito : $cat_name."));
            redirect(base_url().'products/product_category');
        }
    }

    // Update Product;
    public function updateProduct()
    {
        $id = $this->input->post('id');
        $code = strip_tags($this->input->post('code'));
        $name = strip_tags($this->input->post('name'));
        $category = strip_tags($this->input->post('category'));
        $purchase = strip_tags($this->input->post('purchase'));
        $retail = strip_tags($this->input->post('retail'));
        $status = strip_tags($this->input->post('status'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($code)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Aactualizar Producto', 'Ingrese el Codigo del producto!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } elseif (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Aactualizar Producto', 'Ingrese el nombre del producto!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } elseif (empty($category)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Aactualizar Producto', 'Escoja una categoría!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } elseif (empty($purchase)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Aactualizar Producto', 'Ingrese el precio de compra!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } elseif (empty($retail)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Aactualizar Producto', 'Ingrese al por menor!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } else {
            $temp_fn = $_FILES['uploadFile']['name'];
            if (!empty($temp_fn)) {
                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
                    if ($_FILES['uploadFile']['size'] > 2048000) {
                        $this->session->set_flashdata('alert_msg', array('failure', 'Actualizar Producto', 'El tamaño del archivo de carga debe ser inferior a 2 MB!'));
                        redirect(base_url().'products/editproduct?id='.$id);

                        die();
                    }
                } else {
                    $this->session->set_flashdata('alert_msg', array('failure', 'Actualizar Producto', '¡Formato de archivo inválido! Suba el formato de archivo JPG, PNG, JPEG para la imagen del producto!'));
                    redirect(base_url().'products/editproduct?id='.$id);

                    die();
                }
            }

            $upd_data = array(
                    'name' => $name,
                    'category' => $category,
                    'purchase_price' => $purchase,
                    'retail_price' => $retail,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
                    'status' => $status
            );

            $this->Constant_model->updateData('products', $upd_data, $id);

            $mainPhoto_fn = $_FILES['uploadFile']['name'];
            if (!empty($mainPhoto_fn)) {
                $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                $mainPhoto_name = $code.".$main_ext";

                $upd_data = array(
                    'thumbnail' => $mainPhoto_name
            );

            $this->Constant_model->updateData('products', $upd_data, $id);
                

                // Main Photo -- START;
                $config['upload_path'] = './assets/upload/products/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['file_name'] = $mainPhoto_name;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                    //print_r($error);
                    //$this->load->view('upload_form', $error);
                    //$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
                } else {
                    $width_array = array(100, 200);
                    $height_array = array(100, 200);
                    $dir_array = array('xsmall', 'small');

                    $this->load->library('image_lib');

                    for ($i = 0; $i < count($width_array); ++$i) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = "./assets/upload/products/$mainPhoto_name";
                        $config['maintain_ratio'] = true;
                        $config['width'] = $width_array[$i];
                        $config['height'] = $height_array[$i];
                        $config['quality'] = '100%';

                        if (!file_exists('./assets/upload/products/'.$dir_array[$i].'/'.$code)) {
                            mkdir('./assets/upload/products/'.$dir_array[$i].'/'.$code, 0777, true);
                        }

                        $config['new_image'] = './assets/upload/products/'.$dir_array[$i].'/'.$code.'/'.$mainPhoto_name;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }

                    $this->load->helper('file');
                    $path = './assets/upload/products/'.$mainPhoto_name;

                    if (unlink($path)) {

                        echo ($path);
                    }
                }
                // Main Photo -- END;
            }// End of File;

            $this->session->set_flashdata('alert_msg', array('success', 'Actualizar producto', "Producto actualizado exitosamente : $code."));
            redirect(base_url().'products/editproduct?id='.$id);
        }
    }

    // Insert New Product;
    public function insertProduct()
    {
        $code = strip_tags($this->input->post('code'));
        $name = strip_tags($this->input->post('name'));
        $category = strip_tags($this->input->post('category'));
        $purchase = strip_tags($this->input->post('purchase'));
        $retail = strip_tags($this->input->post('retail'));
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($code)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'Ingrese el codigo del producto!'));
            redirect(base_url().'products/addproduct');
        } elseif (!preg_match('#^[a-zA-Z0-9]+$#', $code)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'El código de producto solamente permite letras y carácteres!'));
            redirect(base_url().'products/addproduct');
        } elseif (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'Ingrese el nombre del producto!'));
            redirect(base_url().'products/addproduct');
        } elseif (empty($category)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'Elija una categoría!'));
            redirect(base_url().'products/addproduct');
        } elseif (empty($purchase)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'Ingrese el precio de compra!'));
            redirect(base_url().'products/addproduct');
        } elseif (empty($retail)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'Ingrese el precio al por menor!'));
            redirect(base_url().'products/addproduct');
        } else {
            $temp_fn = $_FILES['uploadFile']['name'];
            if (!empty($temp_fn)) {
                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
                    if ($_FILES['uploadFile']['size'] > 2048000) {
                        $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', 'El tamaño del archivo de carga debe ser inferior a 2 MB!'));
                        redirect(base_url().'products/addproduct');

                        die();
                    }
                } else {
                    $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', '¡Formato de archivo inválido! Suba el formato de archivo JPG, PNG, JPEG para la imagen del producto'));
                    redirect(base_url().'products/addproduct');

                    die();
                }
            }

            $ckPcodeData = $this->Constant_model->getDataOneColumn('products', 'code', "$code");

            if (count($ckPcodeData) == 0) {
                $this->load->library('Barcode39');
                // set Barcode39 object
                $bc = new Barcode39("$code");
                // set text size
                $bc->barcode_text_size = 1;

                // display new barcode
                $bc->draw('./assets/barcode/'.$code.'.gif');

                $ins_data = array(
                        'code' => $code,
                        'name' => $name,
                        'category' => $category,
                        'purchase_price' => $purchase,
                        'retail_price' => $retail,
                        'thumbnail' => 'no_image.jpg',
                        'created_user_id' => $us_id,
                        'created_datetime' => $tm,
                        'status' => '1',
                );
                $pcode_id = $this->Constant_model->insertDataReturnLastId('products', $ins_data);

                $mainPhoto_fn = $_FILES['uploadFile']['name'];
                if (!empty($mainPhoto_fn)) {
                    $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                    $mainPhoto_name = $code.".$main_ext";

                    // Main Photo -- START;
                    $config['upload_path'] = './assets/upload/products/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['file_name'] = $mainPhoto_name;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('uploadFile')) {
                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);
                        //$this->load->view('upload_form', $error);
                        //$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
                    } else {
                        $width_array = array(100, 200);
                        $height_array = array(100, 200);
                        $dir_array = array('xsmall', 'small');

                        $this->load->library('image_lib');

                        for ($i = 0; $i < count($width_array); ++$i) {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = "./assets/upload/products/$mainPhoto_name";
                            $config['maintain_ratio'] = true;
                            $config['width'] = $width_array[$i];
                            $config['height'] = $height_array[$i];
                            $config['quality'] = '100%';

                            if (!file_exists('./assets/upload/products/'.$dir_array[$i].'/'.$code)) {
                                mkdir('./assets/upload/products/'.$dir_array[$i].'/'.$code, 0777, true);
                            }

                            $config['new_image'] = './assets/upload/products/'.$dir_array[$i].'/'.$code.'/'.$mainPhoto_name;

                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }

                        $this->load->helper('file');
                        $path = './assets/upload/products/'.$mainPhoto_name;

                        if (unlink($path)) {
                        }

                        $upd_file_data = array(
                                'thumbnail' => $mainPhoto_name,
                        );
                        $this->Constant_model->updateData('products', $upd_file_data, $pcode_id);
                    }
                    // Main Photo -- END;
                }// End of File;

                $this->session->set_flashdata('alert_msg', array('success', 'Agregar producto', "Producto agregado : $code."));
                redirect(base_url().'products/addproduct');
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Agregar producto', "El codigo : $code Ya existe en el Sistema! Por favor prueba otro!"));
                redirect(base_url().'products/addproduct');
            }
        }
    }

    // Update Product Category;
    public function updateProductCategory()
    {
        $id = $this->input->post('id');
        $category = strip_tags($this->input->post('category'));
        $status = strip_tags($this->input->post('status'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($category)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Actualizar la categoria del producto', 'Por favor ingrese el Nombre de la Categoría del Producto!'));
            redirect(base_url().'products/editproductcategory?id='.$id);
        } else {
            $update_data = array(
                    'name' => $category,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
                    'status' => $status,
            );
            if ($this->Constant_model->updateData('category', $update_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Actualizar la categoria del producto', "Categoría de producto correctamente actualizada : $category."));
                redirect(base_url().'products/editproductcategory?id='.$id);
            }
        }
    }

    // Insert New Product Category;
    public function insertProductCategory()
    {
        $category = strip_tags($this->input->post('category'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($category)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Nueva categoría de producto', 'Por favor ingrese el Nombre de la Categoría del Nuevo Producto!'));
            redirect(base_url().'products/addproductcategory');
        } else {
            $ins_data = array(
                    'name' => $category,
                    'created_user_id' => $us_id,
                    'created_datetime' => $tm,
                    'status' => '1',
            );
            if ($this->Constant_model->insertData('category', $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Nueva categoría de producto', "Se agregó exitosamente una nueva categoría de producto : $category."));
                redirect(base_url().'products/addproductcategory');
            }
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    // Print Barcode -- START;
    public function printBarcode()
    {
        $pcode = $this->input->get('pcode');

        $ckPcodeData = $this->Constant_model->getDataOneColumn('products', 'code', $pcode);

        if (count($ckPcodeData) == 1) {
            $data['pcode'] = $pcode;
            $this->load->view('print_barcode', $data);
        } else {
            $this->session->set_flashdata('alert_msg', array('failure', 'Código de producto incorrecto', 'Código de producto no válido!'));
            redirect(base_url().'products/list_products');
        }
    }
    // Print Barcode -- END;
}
