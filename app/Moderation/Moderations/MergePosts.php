<?php
/**
 * @author    MyBB Group
 * @version   2.0.0
 * @package   mybb/core
 * @license   http://www.mybb.com/licenses/bsd3 BSD-3
 */

namespace MyBB\Core\Moderation\Moderations;

use McCool\LaravelAutoPresenter\HasPresenter;
use MyBB\Core\Database\Models\Post;
use MyBB\Core\Database\Repositories\PostRepositoryInterface;
use MyBB\Core\Moderation\ArrayModerationInterface;
use MyBB\Core\Moderation\SourceableInterface;

class MergePosts implements ArrayModerationInterface, HasPresenter, SourceableInterface
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return string
     */
    public function getKey() : string
    {
        return 'merge_posts';
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return 'moderation.moderate.merge';
    }

    /**
     * @param array $posts
     */
    public function merge(array $posts)
    {
        $this->postRepository->mergePosts($posts);
    }

    /**
     * @param mixed $content
     * @param array $options
     *
     * @return mixed
     */
    public function apply($content, array $options = [])
    {
        if ($this->supports($content)) {
            $this->merge($content);
        }
    }

    /**
     * @param mixed $content
     * @param array $options
     *
     * @return bool
     */
    public function supports($content, array $options = []) : bool
    {
        if (!is_array($content)) {
            return false;
        }

        return is_array_of($content, 'MyBB\Core\Database\Models\Post');
    }

    /**
     * @param mixed $content
     *
     * @return bool
     */
    public function visible($content) : bool
    {
        return $content instanceof Post;
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass() : string
    {
        return 'MyBB\Core\Presenters\Moderations\MergePostsPresenter';
    }

    /**
     * @return string
     */
    public function getPermissionName() : string
    {
        return 'canMergePosts';
    }
}
