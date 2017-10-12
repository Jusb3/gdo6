<?php
namespace GDO\File;
use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\Date\GDT_Duration;
use GDO\DB\GDT_Int;
use GDO\DB\GDT_String;
use GDO\Core\GDOError;
use GDO\Core\GDT_Template;
use GDO\Util\Strings;
/**
 * File database storage.
 * @author gizmore
 * @version 6.0
 * @sinve 3.0
 *
 * @see GDT_File
 */
final class GDO_File extends GDO
{
    ###########
    ### GDO ###
    ###########
    public function gdoColumns()
    {
        return array(
            GDT_AutoInc::make('file_id')->label('id'),
            GDT_String::make('file_name')->notNull(),
            GDT_String::make('file_type')->ascii()->caseS()->notNull()->max(96),
            GDT_Filesize::make('file_size')->notNull(),
            GDT_Int::make('file_width')->unsigned(),
            GDT_Int::make('file_height')->unsigned(),
            GDT_Int::make('file_bitrate')->unsigned(),
            GDT_Duration::make('file_duration'),
            
        );
    }
    
    public function getName() { return $this->getVar('file_name'); }
    public function displayName() { return html($this->getName()); }
    public function getSize() { return $this->getVar('file_size'); }
    public function getType() { return $this->getVar('file_type'); }
    public function displaySize() { return FileUtil::humanFilesize($this->getSize()); }
    public function isImageType() { return Strings::startsWith($this->getType(), 'image/'); }
    
    private $path;
    public function tempPath($path=null)
    {
        $this->path = $path;
        return $this;
    }
    
    private $href;
    public function tempHref($href=null)
    {
        $this->href = $href;
        return $this;
    }
    
    public function getHref() { return $this->href; }
    public function getPath() { return $this->path ? $this->path : $this->getDestPath(); }
    public function getDestPath() { return self::filesDir() . $this->getID(); }
    
//     public function renderCell() { return Template::mainPHP('cell/file.php', ['gdo'=>$this]); }
    
    public function delete()
    {
        @unlink($this->getDestPath());
        return parent::delete();
    }
    
    public function toJSON()
    {
        return array_merge(parent::toJSON(), array(
            'id' => $this->getID(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'size' => $this->getSize(),
            'initial' => true
        ));
    }
    
    ###############
    ### Factory ###
    ###############
    public static function filesDir()
    {
        return GWF_PATH . 'files/';
    }
    
    /**
     * @param array $values
     * @return self
     */
    public static function fromForm(array $values)
    {
        return self::blank(array(
            'file_name' => $values['name'],
            'file_size' => $values['size'],
            'file_type' => $values['mime']
        ))->tempPath($values['path']);
    }
    
    public function copy()
    {
        FileUtil::createDir(self::filesDir());
        $this->insert();
        if (!@copy($this->path, $this->getDestPath()))
        {
            throw new GDOError('err_upload_move', [html($this->path), html($this->getDestPath())]);
        }
        $this->path = null;
        return $this;
    }
    
    /**
     * @param string $contents
     * @return self
     */
    public static function fromString($name, $content)
    {
        # Create temp dir
        $tempDir = GWF_PATH . 'temp/file';
        FileUtil::createDir($tempDir);
        # Copy content to temp file
        $tempPath = $tempDir . '/' . md5(md5($name).md5($content));
        file_put_contents($tempPath, $content);
        # Return fresh File.
        $values = array(
            'name' => $name,
            'size' => strlen($content),
            'mime' => mime_content_type($tempPath),
            'path' => $tempPath,
        );
        return self::fromForm($values);
    }
    
    public function renderCell() { return GDT_Template::php('File', 'cell/file.php', ['gdo'=>$this]); }
}