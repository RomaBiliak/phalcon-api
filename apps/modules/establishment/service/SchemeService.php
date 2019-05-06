<?php
declare(strict_types=1);
namespace Apps\Modules\Establishment\Service;
use Phalcon\Mvc\Controller;
use Apps\Modules\Establishment\Models\Scheme;
use Apps\Common\Helper\ModelMessageArray;
use Apps\Common\Exceptions\{NotFoundException};
class SchemeService extends \Phalcon\DI\Injectable
{

    public function getSchemes():?Scheme
    {
        $schemes = Schemes::find(['establishment_id = :establishment_id: ',
            'bind' => [
                'establishment_id' => $this->establishment->getId(),
            ]]);
        if($schemes !==  false && $schemes->count())
        {
            return $schemes;
        }else{
            throw new NotContentException();
        }
    }
    public function getScheme():?Scheme
    {
        $schemes = Schemes::find(['establishment_id = :establishment_id: AND id = :id:',
            'bind' => [
                'establishment_id' => $this->establishment->getId(),
                'id'    => $this->request->get('scheme_id')
            ]]);
        if($schemes !==  false && $schemes->count())
        {
            return $schemes;
        }else{
            throw new NotContentException();
        }
    }

    public function addScheme():Scheme
    {
        $scheme = new Scheme();
        $data['name'] = $this->request->get('name');
        $data['status'] = $this->request->get('status');
        $data['scheme'] = $this->request->get('scheme');

        if($scheme->save($data) !==  false)
        {
            return $scheme;
        }else{
            throw new ValidateException(serialize(ModelMessageArray::toArray($scheme->getMessages())));
        }
    }
    public function editScheme():Scheme
    {
        $scheme = Scheme::find(['establishment_id = :establishment_id: AND id = :id:',
            'bind' => [
                'establishment_id' => $this->establishment->getId(),
                'id'    => $this->request->get('scheme_id')
            ]]);
        $scheme->name = $this->request->get('name');
        $scheme->status = $this->request->get('status');
        $scheme->scheme = $this->request->get('scheme');

        if($scheme->update() !==  false)
        {
            return $scheme;
        }else{
            throw new ValidateException(serialize(ModelMessageArray::toArray($scheme->getMessages())));
        }
    }
    public function editSchemeStatus():Scheme
    {
        $scheme = Scheme::find(['establishment_id = :establishment_id: AND id = :id:',
            'bind' => [
                'establishment_id' => $this->establishment->getId(),
                'id'    => $this->request->get('scheme_id')
            ]]);
        $scheme->status = $this->request->get('status');

        if($scheme->update() !==  false)
        {
            return $scheme;
        }else{
            throw new ValidateException(serialize(ModelMessageArray::toArray($scheme->getMessages())));
        }
    }

    public function deleteMenu():void
    {
        $scheme = Scheme::find(['establishment_id = :establishment_id: AND id = :id:',
            'bind' => [
                'establishment_id' => $this->establishment->getId(),
                'id'    => $this->request->get('scheme_id')
            ]]);
        $scheme->delete();
    }



}
